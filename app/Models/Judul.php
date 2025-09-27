<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Judul extends Model
{
    //
    protected $table =  'judul';

    protected $fillable = [
        'id_mahasiswa',
        'judul',
        'jenis',
        'pembimbing_satu',
        'pembimbing_dua',
        'penguji_satu',
        'penguji_dua',
    ];

    public function mahasiswa(): BelongsTo {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

}
