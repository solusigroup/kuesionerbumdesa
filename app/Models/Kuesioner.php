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

    protected $appends = ['score'];

    public function getScoreAttribute()
    {
        return $this->x1_1 + $this->x1_2 + $this->x1_3 + $this->x1_4 + $this->x1_5 +
               $this->x2_1 + $this->x2_2 + $this->x2_3 + $this->x2_4 + $this->x2_5 +
               $this->x3_1 + $this->x3_2 + $this->x3_3 + $this->x3_4 + $this->x3_5 +
               $this->y1 + $this->y2 + $this->y3 + $this->y4 + $this->y5;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function winner()
    {
        return $this->hasOne(Winner::class);
    }
}