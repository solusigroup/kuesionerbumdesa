<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index()
    {
        $data = Kuesioner::all();
        $totalRespondents = $data->count();

        if ($totalRespondents === 0) {
            return view('admin.analysis', ['isEmpty' => true]);
        }

        // Calculate Averages for each instrument group
        $stats = [
            'x1' => $this->avgItems($data, 'x1_', 5),
            'x2' => $this->avgItems($data, 'x2_', 5),
            'x3' => $this->avgItems($data, 'x3_', 5),
            'y'  => $this->avgItems($data, 'y', 5),
        ];

        // Group Averages (Composite scores)
        $averages = [
            'x1' => round(collect($stats['x1'])->avg(), 2),
            'x2' => round(collect($stats['x2'])->avg(), 2),
            'x3' => round(collect($stats['x3'])->avg(), 2),
            'y'  => round(collect($stats['y'])->avg(), 2),
        ];

        // --- Uji Kualitas Instrumen (Validitas & Reliabilitas) ---
        $quality = [
            'validity' => [],
            'reliability' => []
        ];

        $vars = [
            'x1' => ['prefix' => 'x1_', 'count' => 5, 'label' => 'Kapasitas Manajerial (X1)'],
            'x2' => ['prefix' => 'x2_', 'count' => 5, 'label' => 'Tekanan Budaya (X2)'],
            'x3' => ['prefix' => 'x3_', 'count' => 5, 'label' => 'Kelemahan Tata Kelola (X3)'],
            'y'  => ['prefix' => 'y',   'count' => 5, 'label' => 'Kualitas Pelaporan (Y)']
        ];

        foreach ($vars as $key => $v) {
            $itemMatrix = [];
            $totalScores = array_fill(0, $totalRespondents, 0);
            
            for ($i = 1; $i <= $v['count']; $i++) {
                $col = ($v['prefix'] === 'y' ? 'y' : $v['prefix']) . $i;
                $scores = $data->pluck($col)->toArray();
                $itemMatrix[] = $scores;
                foreach ($scores as $idx => $s) {
                    $totalScores[$idx] += $s;
                }
            }

            // Validity (Pearson)
            $validityResults = [];
            foreach ($itemMatrix as $idx => $itemScores) {
                $r = $this->calculatePearson($itemScores, $totalScores);
                $validityResults["Butir " . ($idx + 1)] = round($r, 3);
            }
            $quality['validity'][$key] = $validityResults;

            // Reliability (Cronbach's Alpha)
            $alpha = $this->calculateCronbachAlpha($itemMatrix, $totalScores);
            $quality['reliability'][$key] = round($alpha, 3);
        }

        // --- Analisis Regresi Linear Berganda ---
        // Y = a + b1X1 + b2X2 + b3X3
        $regression = null;
        if ($totalRespondents > 3) {
            $x1Arr = []; $x2Arr = []; $x3Arr = []; $yArr = [];
            foreach ($data as $r) {
                $x1Arr[] = ($r->x1_1 + $r->x1_2 + $r->x1_3 + $r->x1_4 + $r->x1_5) / 5;
                $x2Arr[] = ($r->x2_1 + $r->x2_2 + $r->x2_3 + $r->x2_4 + $r->x2_5) / 5;
                $x3Arr[] = ($r->x3_1 + $r->x3_2 + $r->x3_3 + $r->x3_4 + $r->x3_5) / 5;
                $yArr[]  = ($r->y1 + $r->y2 + $r->y3 + $r->y4 + $r->y5) / 5;
            }
            $regression = $this->calculateMultipleRegression($x1Arr, $x2Arr, $x3Arr, $yArr);
        }

        // Distribution data (existing)
        $byKabupaten = Kuesioner::select('kabupaten_kota', DB::raw('count(*) as count'))->groupBy('kabupaten_kota')->pluck('count', 'kabupaten_kota');
        $byJabatan = Kuesioner::select('jabatan', DB::raw('count(*) as count'))->groupBy('jabatan')->pluck('count', 'jabatan');
        $byPendidikan = Kuesioner::select('pendidikan_terakhir', DB::raw('count(*) as count'))->groupBy('pendidikan_terakhir')->pluck('count', 'pendidikan_terakhir');
        $byPelatihan = Kuesioner::select('pernah_pelatihan', DB::raw('count(*) as count'))->groupBy('pernah_pelatihan')->pluck('count', 'pernah_pelatihan');
        $byAplikasi = Kuesioner::select('menggunakan_aplikasi', DB::raw('count(*) as count'))->groupBy('menggunakan_aplikasi')->pluck('count', 'menggunakan_aplikasi');
        $byFrekuensi = Kuesioner::select('frekuensi_pelatihan', DB::raw('count(*) as count'))->whereNotNull('frekuensi_pelatihan')->groupBy('frekuensi_pelatihan')->pluck('count', 'frekuensi_pelatihan');

        return view('admin.analysis', compact('stats', 'averages', 'totalRespondents', 'byKabupaten', 'byJabatan', 'byPendidikan', 'quality', 'regression', 'byPelatihan', 'byAplikasi', 'byFrekuensi'));
    }

    private function avgItems($collection, $prefix, $count)
    {
        $results = [];
        for ($i = 1; $i <= $count; $i++) {
            $column = ($prefix === 'y' ? 'y' : $prefix) . $i;
            $results["Butir $i"] = round($collection->avg($column), 2);
        }
        return $results;
    }

    // --- Statistical Helpers ---

    private function calculatePearson($x, $y)
    {
        $n = count($x);
        if ($n === 0) return 0;
        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumXY = 0; $sumX2 = 0; $sumY2 = 0;
        for ($i = 0; $i < $n; $i++) {
            $sumXY += ($x[$i] * $y[$i]);
            $sumX2 += ($x[$i] ** 2);
            $sumY2 += ($y[$i] ** 2);
        }
        $num = ($n * $sumXY) - ($sumX * $sumY);
        $val = (($n * $sumX2) - ($sumX ** 2)) * (($n * $sumY2) - ($sumY ** 2));
        if ($val < 0) $val = 0; // Mencegah hasil negatif akibat floating point error
        $den = sqrt($val);
        return $den == 0 ? 0 : $num / $den;
    }

    private function calculateVariance($data)
    {
        $n = count($data);
        if ($n < 2) return 0;
        $mean = array_sum($data) / $n;
        $sumSq = 0;
        foreach ($data as $v) $sumSq += ($v - $mean) ** 2;
        return $sumSq / ($n - 1);
    }

    private function calculateCronbachAlpha($itemMatrix, $totalScores)
    {
        $k = count($itemMatrix);
        if ($k <= 1) return 0;
        $sumItemVariances = 0;
        foreach ($itemMatrix as $itemScores) {
            $sumItemVariances += $this->calculateVariance($itemScores);
        }
        $totalVariance = $this->calculateVariance($totalScores);
        if ($totalVariance == 0) return 0;
        return ($k / ($k - 1)) * (1 - ($sumItemVariances / $totalVariance));
    }

    private function calculateMultipleRegression($x1, $x2, $x3, $y)
    {
        $n = count($y);
        $mainReg = $this->calculateOLS($x1, $x2, $x3, $y);
        
        if (!$mainReg || $n <= 4) return $mainReg;

        // --- 1. Uji Normalitas (Jarque-Bera) ---
        $res = [];
        for ($i = 0; $i < $n; $i++) {
            $yPred = $mainReg['a'] + $mainReg['b1']*$x1[$i] + $mainReg['b2']*$x2[$i] + $mainReg['b3']*$x3[$i];
            $res[] = $y[$i] - $yPred;
        }
        $meanRes = array_sum($res) / $n;
        $m2 = 0; $m3 = 0; $m4 = 0;
        foreach ($res as $e) {
            $diff = $e - $meanRes;
            $m2 += $diff ** 2;
            $m3 += $diff ** 3;
            $m4 += $diff ** 4;
        }
        $m2 = $m2 / $n; $m3 = $m3 / $n; $m4 = $m4 / $n;
        
        $S = $m2 > 0 ? $m3 / ($m2 ** 1.5) : 0;
        $K = $m2 > 0 ? $m4 / ($m2 ** 2) : 3;
        $JB = ($n / 6) * ($S**2 + (($K - 3)**2) / 4);
        
        // --- 2. Uji Multikolinearitas (VIF & Tolerance) ---
        $r12 = $this->calculatePearson($x1, $x2);
        $r13 = $this->calculatePearson($x1, $x3);
        $r23 = $this->calculatePearson($x2, $x3);
        $Rx = [
            [1, $r12, $r13],
            [$r12, 1, $r23],
            [$r13, $r23, 1]
        ];
        $Rx_inv = $this->invertMatrix($Rx);
        $vif = [];
        if ($Rx_inv) {
            $vif['x1'] = round($Rx_inv[0][0], 3);
            $vif['x2'] = round($Rx_inv[1][1], 3);
            $vif['x3'] = round($Rx_inv[2][2], 3);
        } else {
            $vif = ['x1' => 0, 'x2' => 0, 'x3' => 0];
        }
        
        // --- 3. Uji Heteroskedastisitas (Uji Glejser) ---
        $absRes = array_map('abs', $res);
        $glejserReg = $this->calculateOLS($x1, $x2, $x3, $absRes);
        
        $mainReg['asumsi'] = [
            'normalitas' => [
                'jb' => round($JB, 3),
                'status' => $JB < 5.99 ? 'Normal' : 'Tidak Normal' // 5.99 = chi-square df=2, alpha=0.05
            ],
            'multikolinearitas' => [
                'vif_x1' => $vif['x1'],
                'vif_x2' => $vif['x2'],
                'vif_x3' => $vif['x3'],
                'status' => ($vif['x1'] < 10 && $vif['x2'] < 10 && $vif['x3'] < 10) ? 'Bebas Multikolinearitas' : 'Ada Multikolinearitas'
            ],
            'heteroskedastisitas' => [
                't_x1' => $glejserReg ? round($glejserReg['t_b1'], 3) : 0,
                't_x2' => $glejserReg ? round($glejserReg['t_b2'], 3) : 0,
                't_x3' => $glejserReg ? round($glejserReg['t_b3'], 3) : 0,
                'status' => ($glejserReg && abs($glejserReg['t_b1']) < 2.0 && abs($glejserReg['t_b2']) < 2.0 && abs($glejserReg['t_b3']) < 2.0) 
                            ? 'Bebas Heteroskedastisitas' : 'Ada Heteroskedastisitas'
            ]
        ];

        return $mainReg;
    }

    private function calculateOLS($x1, $x2, $x3, $y)
    {
        $n = count($y);
        // We need to solve (X'X)b = X'y
        // X is [1, x1, x2, x3]
        $X = [];
        for ($i = 0; $i < $n; $i++) {
            $X[] = [1, $x1[$i], $x2[$i], $x3[$i]];
        }

        // Build X'X (4x4)
        $XTX = array_fill(0, 4, array_fill(0, 4, 0));
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                for ($k = 0; $k < $n; $k++) {
                    $XTX[$i][$j] += $X[$k][$i] * $X[$k][$j];
                }
            }
        }

        // Build X'y (4x1)
        $XTy = array_fill(0, 4, 0);
        for ($i = 0; $i < 4; $i++) {
            for ($k = 0; $k < $n; $k++) {
                $XTy[$i] += $X[$k][$i] * $y[$k];
            }
        }

        // Solve XTX * b = XTy using Gaussian Elimination
        $b = $this->solveLinearSystem($XTX, $XTy);

        if (!$b) return null;

        // Calculate R-Squared
        $yMean = array_sum($y) / $n;
        $ssTot = 0; $ssRes = 0;
        for ($i = 0; $i < $n; $i++) {
            $ssTot += ($y[$i] - $yMean) ** 2;
            $yPred = $b[0] + $b[1]*$x1[$i] + $b[2]*$x2[$i] + $b[3]*$x3[$i];
            $ssRes += ($y[$i] - $yPred) ** 2;
        }
        $rSquared = $ssTot == 0 ? 0 : 1 - ($ssRes / $ssTot);

        // --- Tambahan Uji F, Uji t, dan Standard Error ---
        $p = 4; // Jumlah parameter (1 konstanta + 3 variabel independen)
        $k = 3; // Jumlah variabel independen
        
        $fValue = 0;
        $se = array_fill(0, $p, 0);
        $t = array_fill(0, $p, 0);

        // Hanya bisa dihitung jika df residual > 0 (jumlah sampel > jumlah parameter)
        if ($n > $p) {
            $ssReg = $ssTot - $ssRes;
            $msReg = $ssReg / $k;
            $msRes = $ssRes / ($n - $p);
            
            // Uji F
            $fValue = $msRes > 0 ? $msReg / $msRes : 0;

            // Invers dari (X'X) untuk mendapatkan varians-kovarians koefisien
            $XTX_inv = $this->invertMatrix($XTX);
            
            if ($XTX_inv) {
                for ($i = 0; $i < $p; $i++) {
                    $var_coef = $msRes * $XTX_inv[$i][$i];
                    // Standard Error (SE)
                    $se[$i] = $var_coef > 0 ? sqrt($var_coef) : 0;
                    // Uji t (t-hitung)
                    $t[$i]  = $se[$i] > 0 ? $b[$i] / $se[$i] : 0;
                }
            }
        }

        return [
            'a'  => round($b[0], 4),
            'b1' => round($b[1], 4),
            'b2' => round($b[2], 4),
            'b3' => round($b[3], 4),
            'r2' => round($rSquared, 4),
            'f_value' => round($fValue, 4),
            'se_a'  => round($se[0], 4),
            'se_b1' => round($se[1], 4),
            'se_b2' => round($se[2], 4),
            'se_b3' => round($se[3], 4),
            't_a'  => round($t[0], 4),
            't_b1' => round($t[1], 4),
            't_b2' => round($t[2], 4),
            't_b3' => round($t[3], 4),
        ];
    }

    private function solveLinearSystem($A, $B)
    {
        $n = count($B);
        for ($i = 0; $i < $n; $i++) {
            // Search for maximum in this column
            $maxEl = abs($A[$i][$i]);
            $maxRow = $i;
            for ($k = $i + 1; $k < $n; $k++) {
                if (abs($A[$k][$i]) > $maxEl) {
                    $maxEl = abs($A[$k][$i]);
                    $maxRow = $k;
                }
            }

            // Swap maximum row with current row (column by column)
            for ($k = $i; $k < $n; $k++) {
                $tmp = $A[$maxRow][$k];
                $A[$maxRow][$k] = $A[$i][$k];
                $A[$i][$k] = $tmp;
            }
            $tmp = $B[$maxRow];
            $B[$maxRow] = $B[$i];
            $B[$i] = $tmp;

            // Make all rows below this one 0 in current column
            if (abs($A[$i][$i]) < 1e-10) return null; // Singular matrix (dengan toleransi floating point)
            for ($k = $i + 1; $k < $n; $k++) {
                $c = -$A[$k][$i] / $A[$i][$i];
                for ($j = $i; $j < $n; $j++) {
                    if ($i == $j) {
                        $A[$k][$j] = 0;
                    } else {
                        $A[$k][$j] += $c * $A[$i][$j];
                    }
                }
                $B[$k] += $c * $B[$i];
            }
        }

        // Solve equation Ax=B for an upper triangular matrix A
        $x = array_fill(0, $n, 0);
        for ($i = $n - 1; $i >= 0; $i--) {
            $x[$i] = $B[$i] / $A[$i][$i];
            for ($k = $i - 1; $k >= 0; $k--) {
                $B[$k] -= $A[$k][$i] * $x[$i];
            }
        }
        return $x;
    }

    private function invertMatrix($A)
    {
        $n = count($A);
        $inverse = array_fill(0, $n, array_fill(0, $n, 0));
        for ($col = 0; $col < $n; $col++) {
            $b = array_fill(0, $n, 0);
            $b[$col] = 1;
            $x = $this->solveLinearSystem($A, $b);
            if ($x === null) return null; // Matriks singular
            for ($i = 0; $i < $n; $i++) {
                $inverse[$i][$col] = $x[$i];
            }
        }
        return $inverse;
    }
}
