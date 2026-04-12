<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prodi extends Model
{
    //

    protected $table = 'prodi';

    protected $fillable =[
       'nama_prodi',
        'jenjang'

    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'prodi_id');
    }

    public function mahasiswa(): HasOne
    {
        return $this->hasOne(Mahasiswa::class, 'prodi_id');
    }

}
