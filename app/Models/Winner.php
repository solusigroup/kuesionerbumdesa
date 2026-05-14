<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $fillable = ['kuesioner_id'];

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }
}
