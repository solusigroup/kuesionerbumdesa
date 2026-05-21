<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterviewLog;
use App\Models\Kuesioner;

class InterviewController extends Controller
{
    public function index(Request $request)
    {
        $query = InterviewLog::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_bumdesa', 'like', "%{$search}%")
                  ->orWhere('nama_narasumber', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $logs = $query->get();

        return view('interview.index', compact('logs'));
    }

    public function create()
    {
        // Ambil daftar nama BUMDesa unik dari data responden, diurutkan A-Z
        $bumdesaList = Kuesioner::select('nama_bumdesa')
            ->distinct()
            ->orderBy('nama_bumdesa')
            ->pluck('nama_bumdesa');

        return view('interview.create', compact('bumdesaList'));
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
