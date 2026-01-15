<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'meeting_id',
        'passcode',
        'signed',
        'softcopy_file_path',
        'status_ujian'
    ];

    public function judul() : BelongsTo {
        return $this->belongsTo(Judul::class, 'id_judul');
    }

    public function statusUndangan(): HasOne {
        return $this->hasOne(StatusUndangan::class, 'id_undangan');
    }
}
