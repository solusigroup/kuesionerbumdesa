<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\Winner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Kuesioner::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_responden', 'like', "%{$search}%")
                  ->orWhere('nama_bumdesa', 'like', "%{$search}%")
                  ->orWhere('nama_desa', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kabupaten_kota', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kabupaten_kota')) {
            $query->where('kabupaten_kota', $request->kabupaten_kota);
        }

        $kuesioners = $query->get();
        $kabupaten_list = Kuesioner::distinct()->whereNotNull('kabupaten_kota')->pluck('kabupaten_kota');

        return view('admin.dashboard', compact('kuesioners', 'kabupaten_list'));
    }

    public function whatsapp(Request $request)
    {
        $query = Kuesioner::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_responden', 'like', "%{$search}%")
                  ->orWhere('nama_bumdesa', 'like', "%{$search}%")
                  ->orWhere('nomor_wa', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kabupaten_kota')) {
            $query->where('kabupaten_kota', $request->kabupaten_kota);
        }

        $kuesioners = $query->get();
        $kabupaten_list = Kuesioner::distinct()->whereNotNull('kabupaten_kota')->pluck('kabupaten_kota');

        return view('admin.whatsapp', compact('kuesioners', 'kabupaten_list'));
    }

    public function show($id)
    {
        $kuesioner = Kuesioner::with('user')->findOrFail($id);
        return view('admin.show', compact('kuesioner'));
    }

    public function export()
    {
        $kuesioners = Kuesioner::with('user')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="hasil_kuesioner_bumdesa_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function () use ($kuesioners) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID', 'Email Akun', 'Nama Responden', 'Nomor WA', 'Email BUMDesa', 
                'Jenis Kelamin', 'Usia', 'Jabatan', 
                'Nama BUMDesa', 'Nama Desa', 'Kecamatan', 'Kabupaten/Kota', 
                'Lama Menjabat', 'Pendidikan Terakhir', 
                'Pernah Pelatihan', 'Menggunakan Aplikasi', 'Frekuensi Pelatihan',
                'X1.1', 'X1.2', 'X1.3', 'X1.4', 'X1.5',
                'X2.1', 'X2.2', 'X2.3', 'X2.4', 'X2.5',
                'X3.1', 'X3.2', 'X3.3', 'X3.4', 'X3.5',
                'Y.1', 'Y.2', 'Y.3', 'Y.4', 'Y.5',
                'Hambatan Besar', 'Pengaruh Budaya', 'Perbaikan Dibutuhkan', 'Tanggal Submit'
            ]);

            foreach ($kuesioners as $k) {
                fputcsv($file, [
                    $k->id,
                    $k->user->email ?? '-',
                    $k->nama_responden,
                    $k->nomor_wa,
                    $k->email_bumdesa,
                    $k->jenis_kelamin,
                    $k->usia,
                    $k->jabatan,
                    $k->nama_bumdesa,
                    $k->nama_desa,
                    $k->kecamatan,
                    $k->kabupaten_kota,
                    $k->lama_menjabat,
                    $k->pendidikan_terakhir,
                    $k->pernah_pelatihan,
                    $k->menggunakan_aplikasi,
                    $k->frekuensi_pelatihan,
                    $k->x1_1, $k->x1_2, $k->x1_3, $k->x1_4, $k->x1_5,
                    $k->x2_1, $k->x2_2, $k->x2_3, $k->x2_4, $k->x2_5,
                    $k->x3_1, $k->x3_2, $k->x3_3, $k->x3_4, $k->x3_5,
                    $k->y1, $k->y2, $k->y3, $k->y4, $k->y5,
                    $k->hambatan_besar,
                    $k->pengaruh_budaya,
                    $k->perbaikan_dibutuhkan,
                    $k->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function destroy($id)
    {
        $kuesioner = Kuesioner::findOrFail($id);
        $kuesioner->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data kuesioner berhasil dihapus.');
    }

    public function lottery()
    {
        $winners = Winner::with('kuesioner')->get();
        
        $candidates = Kuesioner::select('*')
            ->selectRaw('(x1_1 + x1_2 + x1_3 + x1_4 + x1_5 + x2_1 + x2_2 + x2_3 + x2_4 + x2_5 + x3_1 + x3_2 + x3_3 + x3_4 + x3_5 + y1 + y2 + y3 + y4 + y5) as total_score')
            ->orderByDesc('total_score')
            ->limit(10)
            ->get();

        return view('admin.lottery', compact('winners', 'candidates'));
    }

    public function performLottery()
    {
        // Clear old winners
        Winner::truncate();

        // Get top 10 candidates
        $candidates = Kuesioner::select('*')
            ->selectRaw('(x1_1 + x1_2 + x1_3 + x1_4 + x1_5 + x2_1 + x2_2 + x2_3 + x2_4 + x2_5 + x3_1 + x3_2 + x3_3 + x3_4 + x3_5 + y1 + y2 + y3 + y4 + y5) as total_score')
            ->orderByDesc('total_score')
            ->limit(10)
            ->get();

        if ($candidates->count() > 0) {
            // Draw 3 random ones from top 10
            $luckyOnes = $candidates->random(min(3, $candidates->count()));
            foreach ($luckyOnes as $lucky) {
                Winner::create(['kuesioner_id' => $lucky->id]);
            }
        }

        return redirect()->route('admin.lottery')->with('success', 'Pengundian berhasil dilakukan!');
    }
}
