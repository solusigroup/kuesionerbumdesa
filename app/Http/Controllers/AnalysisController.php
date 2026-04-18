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

        // Distribution by Kabupaten
        $byKabupaten = Kuesioner::select('kabupaten_kota', DB::raw('count(*) as count'))
            ->groupBy('kabupaten_kota')
            ->pluck('count', 'kabupaten_kota');

        // Distribution by Jabatan
        $byJabatan = Kuesioner::select('jabatan', DB::raw('count(*) as count'))
            ->groupBy('jabatan')
            ->pluck('count', 'jabatan');

        // Distribution by Pendidikan
        $byPendidikan = Kuesioner::select('pendidikan_terakhir', DB::raw('count(*) as count'))
            ->groupBy('pendidikan_terakhir')
            ->pluck('count', 'pendidikan_terakhir');

        return view('admin.analysis', compact('stats', 'averages', 'totalRespondents', 'byKabupaten', 'byJabatan', 'byPendidikan'));
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
}
