<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsulanJudul extends Model
{
    //
    protected $table = 'usulan_judul';

    protected $fillable = [
        'id_mahasiswa',
        'minat_kekuhusan',
        'judul_satu',
        'judul_dua',
        'judul_tiga',
        'status',
        'catatan'
    ];

    public function mahasiswa(): BelongsTo{
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }
}
