<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeputusan extends Model
{
    //
    protected $table = 'surat_keputusan';

    protected $fillable = [
      'id_judul',
      'nomor_sk_penguji',
      'nomor_sk_pembimbing',
    ];


    public function judul(): BelongsTo {
        return $this->belongsTo(Judul::class, 'id_judul');
    }
}
