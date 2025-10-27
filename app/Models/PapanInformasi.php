<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PapanInformasi extends Model
{
    //
    protected $table = 'papan_informasi';

    protected $fillable = [
        'yt_url',
        'jadwal_proposal',
        'jadwal_skripsi',
        'pengajuan_judul',
        'running_text',
    ];

    protected $casts = [
        'jadwal_proposal' => 'array',
        'jadwal_skripsi' => 'array',
        'pengajuan_judul' => 'array',
    ];
}
