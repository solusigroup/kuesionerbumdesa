<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterviewLog;

class InterviewController extends Controller
{
    public function create()
    {
        return view('interview.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bumdesa' => 'required|string|max:255',
            'nama_narasumber' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        // Menyimpan data transkrip wawancara
        InterviewLog::create($request->all());

        return redirect()->route('interview.create')->with('success', 'Catatan wawancara berhasil disimpan di server!');
    }

    // FITUR BARU: Ekspor Data ke Excel
    public function exportExcel() 
    {
        // Mengambil semua data hasil wawancara dari database
        $logs = InterviewLog::all();
        
        // Memanggil file view khusus format excel dan me-render kodenya
        $content = view('interview.excel', compact('logs'))->render();
        
        // Mengirimkan response dengan header agar browser otomatis mendownload sebagai file Excel (.xls)
        return response($content)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=Transkrip_Wawancara_BUMDesa.xls')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
