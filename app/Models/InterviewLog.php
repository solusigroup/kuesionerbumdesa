<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewLog extends Model
{
    protected $table = 'interview_logs';

    protected $fillable = [
        'nama_bumdesa',
        'nama_narasumber',
        'jabatan',
        'transkrip_kapasitas_x1',
        'transkrip_budaya_x2',
        'transkrip_tata_kelola_x3',
        'transkrip_pelaporan_y',
    ];
}
