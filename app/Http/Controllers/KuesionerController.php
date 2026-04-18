<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kuesioners = Kuesioner::where('user_id', auth()->id())->latest()->get();
        return view('kuesioner', compact('kuesioners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Kuesioner::where('user_id', auth()->id())->exists()) {
            return redirect()->route('kuesioner.index')->with('info', 'Anda sudah mengisi kuesioner.');
        }
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Kuesioner::where('user_id', auth()->id())->exists()) {
            return redirect()->route('kuesioner.index')->with('error', 'Anda sudah mengisi kuesioner.');
        }

        $validated = $request->validate([
            'nama_responden' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'usia' => 'required|integer|min:1',
            'jabatan' => 'required|string|max:100',
            'nama_bumdesa' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:100',
            'lama_menjabat' => 'required|string|max:50',
            'pendidikan_terakhir' => 'required|string|max:50',
            'pernah_pelatihan' => 'required|in:Ya,Tidak',
            'menggunakan_aplikasi' => 'required|in:Ya,Tidak',
            'frekuensi_pelatihan' => 'nullable|string|max:50',
            
            // Validate scale values 1-5
            'x1_1' => 'required|integer|between:1,5',
            'x1_2' => 'required|integer|between:1,5',
            'x1_3' => 'required|integer|between:1,5',
            'x1_4' => 'required|integer|between:1,5',
            'x1_5' => 'required|integer|between:1,5',
            'x2_1' => 'required|integer|between:1,5',
            'x2_2' => 'required|integer|between:1,5',
            'x2_3' => 'required|integer|between:1,5',
            'x2_4' => 'required|integer|between:1,5',
            'x2_5' => 'required|integer|between:1,5',
            'x3_1' => 'required|integer|between:1,5',
            'x3_2' => 'required|integer|between:1,5',
            'x3_3' => 'required|integer|between:1,5',
            'x3_4' => 'required|integer|between:1,5',
            'x3_5' => 'required|integer|between:1,5',
            'y1' => 'required|integer|between:1,5',
            'y2' => 'required|integer|between:1,5',
            'y3' => 'required|integer|between:1,5',
            'y4' => 'required|integer|between:1,5',
            'y5' => 'required|integer|between:1,5',
            
            'hambatan_besar' => 'nullable|string',
            'pengaruh_budaya' => 'nullable|string',
            'perbaikan_dibutuhkan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        Kuesioner::create($validated);

        return redirect()->route('kuesioner.index')->with('success', 'Kuesioner berhasil disimpan.');
    }
}