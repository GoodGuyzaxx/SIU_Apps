<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    //
    protected $table = 'mahasiswa';

    protected $fillable = [
        'id_user',
        'nama',
        'npm',
        'program_studi',
        'kelas',
        'jenjang',
        'agama',
        'nomor_hp',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
