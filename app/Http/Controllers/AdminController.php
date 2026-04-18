<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index()
    {
        $kuesioners = Kuesioner::with('user')->latest()->get();
        return view('admin.dashboard', compact('kuesioners'));
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
                'ID', 'Email Responden', 'Nama Responden', 'Jenis Kelamin', 'Usia', 'Jabatan', 
                'Nama BUMDesa', 'Kabupaten/Kota', 'Lama Menjabat', 'Pendidikan Terakhir', 
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
                    $k->jenis_kelamin,
                    $k->usia,
                    $k->jabatan,
                    $k->nama_bumdesa,
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
}
