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
        $den = sqrt((($n * $sumX2) - ($sumX ** 2)) * (($n * $sumY2) - ($sumY ** 2)));
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

        return [
            'a'  => round($b[0], 4),
            'b1' => round($b[1], 4),
            'b2' => round($b[2], 4),
            'b3' => round($b[3], 4),
            'r2' => round($rSquared, 4)
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
            if ($A[$i][$i] == 0) return null; // Singular matrix
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
}
