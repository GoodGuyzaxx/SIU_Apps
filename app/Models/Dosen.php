<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dosen extends Model
{
    //
    protected $table = 'dosen';

    protected $fillable = [
        'id_user',
        'nama',
        'nidn',
        'nrp_nip',
        'inisial_dosen',
        'ttl',
        'nomor_hp'

    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id_user');
    }

}
