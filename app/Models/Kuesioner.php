<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $table = 'kuesioners';

    protected $fillable = [
        'user_id',
        'nama_responden',
        'nomor_wa',
        'email_bumdesa',
        'jenis_kelamin',
        'usia',
        'jabatan',
        'nama_bumdesa',
        'nama_desa',
        'kecamatan',
        'kabupaten_kota',
        'lama_menjabat',
        'pendidikan_terakhir',
        'pernah_pelatihan',
        'menggunakan_aplikasi',
        'frekuensi_pelatihan',
        'x1_1', 'x1_2', 'x1_3', 'x1_4', 'x1_5',
        'x2_1', 'x2_2', 'x2_3', 'x2_4', 'x2_5',
        'x3_1', 'x3_2', 'x3_3', 'x3_4', 'x3_5',
        'y1', 'y2', 'y3', 'y4', 'y5',
        'hambatan_besar',
        'pengaruh_budaya',
        'perbaikan_dibutuhkan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}