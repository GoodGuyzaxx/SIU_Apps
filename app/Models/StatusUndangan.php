<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusUndangan extends Model
{
    //
    protected $table = 'status_undangan';
    protected $fillable = [
        'id_undangan',
        'id_dosen',
        'role',
        'status_konfirmasi',
        'alasan_penolakan',
        'confirmed_at',
    ];


    public function undangan() : BelongsTo {
        return $this->belongsTo(Undangan::class, 'id_undangan');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id_dosen');

    }


}
