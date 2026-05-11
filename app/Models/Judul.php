<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Judul extends Model
{
    //
    protected $table =  'judul';

    protected $fillable = [
        'id_mahasiswa',
        'tahun_akademik_id',
        'minat',
        'judul',
        'rev_judul',
        'status_rev_judul',
        'pembimbing_satu',
        'pembimbing_dua',
        'penguji_satu',
        'penguji_dua',
        'status'
    ];


    public function mahasiswa(): BelongsTo {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function pembimbingSatu(): BelongsTo {
        return $this->belongsTo(Dosen::class, 'pembimbing_satu');
    }

    public function pembimbingDua(): BelongsTo {
        return $this->belongsTo(Dosen::class, 'pembimbing_dua');
    }

    public function pengujiSatu(): BelongsTo {
        return $this->belongsTo(Dosen::class, 'penguji_satu');
    }

    public function pengujiDua(): BelongsTo {
        return $this->belongsTo(Dosen::class, 'penguji_dua');
    }

    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function nilai(): HasOne
    {
        return $this->hasOne(Nilai::class, 'judul_id');
    }

    public function suratKeputusan(): HasOne
    {
        return $this->hasOne(SuratKeputusan::class, 'id_judul');
    }

    public function undangans(): HasMany
    {
        return $this->hasMany(Undangan::class, 'id_judul');
    }

    protected static function booted()
    {
        parent::booted();

        static::created(function ($model) {
            $model->nilai()->create();
            $model->suratKeputusan()->create([
                'nomor_sk_penguji'   => "HARAP ISI NOMOR",
                'nomor_sk_pembimbing' => "HARAP ISI NOMOR"
            ]);
        });

        // Jika rev_judul baru diisi (dari kosong/null), ubah status_rev_judul menjadi 'sudah_revisi'
        static::updating(function ($model) {
            if ($model->isDirty('rev_judul')
                && !empty($model->rev_judul)
                && empty($model->getOriginal('rev_judul'))
            ) {
                $model->status_rev_judul = 'sudah_revisi';
            }
        });
    }

}
