<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    //
    protected $table = 'nilai';

    protected $fillable = [
        'judul_id',
        'nilai_porposal',
        'nilai_porposal_angka',
        'tanggal_ujian_proposal',
        'nilai_hasil',
        'nilai_hasil_angka',
        'tanggal_ujian_hasil'
    ];


    public function judul(): BelongsTo
    {
        return $this->belongsTo(Judul::class, 'judul_id');
    }


}
