<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    //
    protected $table = 'mahasiswa';

    protected $fillable = [
        'id_user',
        'prodi_id',
        'nama',
        'npm',
        'program_studi',
        'kelas',
        'jenjang',
        'agama',
        'nomor_hp',
        'angkatan'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user','id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function usulanJuduls(): HasMany
    {
        return $this->hasMany(UsulanJudul::class, 'id_mahasiswa');
    }
}


