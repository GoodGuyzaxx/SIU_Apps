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
        'nilai_proposal',
        'nilai_proposal_angka',
        'tanggal_ujian_proposal',
        'nilai_hasil',
        'nilai_hasil_angka',
        'tanggal_ujian_hasil'
    ];


    public function judul(): BelongsTo
    {
        return $this->belongsTo(Judul::class, 'judul_id');
    }

    /**
     * Tentukan status judul berdasarkan tanggal ujian yang sudah diisi.
     */
    public function determineJudulStatus(): string
    {
        if (!empty($this->tanggal_ujian_hasil)) {
            return 'hasil';
        }

        if (!empty($this->tanggal_ujian_proposal)) {
            return 'proposal';
        }

        return 'pengajuan';
    }

    /**
     * Sinkronkan status Judul berdasarkan data Nilai saat ini.
     */
    public function syncJudulStatus(): void
    {
        $judul = $this->judul;

        if (!$judul) {
            return;
        }

        $newStatus = $this->determineJudulStatus();

        if ($judul->status !== $newStatus) {
            $judul->update(['status' => $newStatus]);
        }

        // Jika nilai proposal sudah diinput, ubah status_rev_judul menjadi 'ya'
        $nilaiProposalTerisi = !empty($this->nilai_proposal)
            || !empty($this->nilai_proposal_angka)
            || !empty($this->tanggal_ujian_proposal);

        if ($nilaiProposalTerisi && $judul->status_rev_judul !== 'ya') {
            $judul->update(['status_rev_judul' => 'ya']);
        }
    }

    protected static function booted(): void
    {
        parent::booted();

        // Auto-update status Judul setiap kali Nilai disimpan (create/update)
        static::saved(function (Nilai $nilai) {
            $nilai->syncJudulStatus();
        });
    }
}
