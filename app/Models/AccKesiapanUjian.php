<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AccKesiapanUjian extends Model
{
    protected $table = 'acc_kesiapan_ujian';

    protected $fillable = [
        'id_undangan',
        'id_dosen',
        'role',
        'status',
        'alasan_penolakan',
        'token',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    /**
     * Boot the model and auto-generate token.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->token)) {
                $model->token = Str::random(64);
            }
        });
    }

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class , 'id_undangan');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class , 'id_dosen');
    }

    /**
     * Check if ACC is still pending (can be responded to).
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if ACC has been approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'disetujui';
    }

    /**
     * Check if ACC has been rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'ditolak';
    }
}