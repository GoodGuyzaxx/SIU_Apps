<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfigDokumen extends Model
{
    //

    protected $table = 'config_dokumen';

    protected $fillable = [
        'prodi_id',
        'nama',
        'ttd',
        'jenjang',
        'jabatan',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

}
