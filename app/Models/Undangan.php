<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Undangan extends Model
{
    //
    protected $table = 'undangan';

    protected $fillable = [
        'id_judul',
        'nomor',
        'perihal',
        'tanggal_hari',
        'waktu',
        'tempat',
    ];

    public function judul() : BelongsTo {
        return $this->belongsTo(Judul::class, 'id_judul');
    }
}
