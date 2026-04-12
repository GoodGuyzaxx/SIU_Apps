<?php

namespace App\Observers;

use App\Models\AccKesiapanUjian;
use App\Models\Undangan;
use App\Services\WhatsappService;

class StatusUndangaObserver
{
    /**
     * Handle the AccKesiapanUjian "created" event.
     */
    public function created(AccKesiapanUjian $accKesiapanUjian): void
    {
        $this->checkAndUpdateStatusUjian($accKesiapanUjian->id_undangan);
    }

    /**
     * Handle the AccKesiapanUjian "updated" event.
     */
    public function updated(AccKesiapanUjian $accKesiapanUjian): void
    {
        $this->checkAndUpdateStatusUjian($accKesiapanUjian->id_undangan);
    }

    /**
     * Handle the AccKesiapanUjian "deleted" event.
     */
    public function deleted(AccKesiapanUjian $accKesiapanUjian): void
    {
        //
    }

    /**
     * Handle the AccKesiapanUjian "restored" event.
     */
    public function restored(AccKesiapanUjian $accKesiapanUjian): void
    {
        //
    }

    /**
     * Handle the AccKesiapanUjian "force deleted" event.
     */
    public function forceDeleted(AccKesiapanUjian $accKesiapanUjian): void
    {
        //
    }

    private function checkAndUpdateStatusUjian($idUndangan)
    {
        $undangan = Undangan::find($idUndangan);

        if (!$undangan) return;

        // Jangan update jika sudah gagal atau selesai
        if (in_array($undangan->status_ujian, ['gagal_menjadwalkan_ujian', 'selesai'])) {
            return;
        }

        // Gunakan pengecekan syarat minimum dari WhatsappService
        $check = WhatsappService::checkMinimumRequirements($idUndangan);

        if ($check['terpenuhi']) {
            // Syarat dosen terpenuhi, cek draft
            if (!empty($undangan->softcopy_file_path)) {
                // Draft sudah ada → siap ujian
                $undangan->update(['status_ujian' => 'ready_to_exam']);
            } else {
                // Draft belum ada → dijadwalkan, menunggu draft
                if ($undangan->status_ujian === 'menunggu_acc') {
                    $undangan->update(['status_ujian' => 'dijadwalkan']);
                }
            }
        } elseif ($check['tidak_mungkin']) {
            // Tidak mungkin terpenuhi
            $undangan->update(['status_ujian' => 'gagal_menjadwalkan_ujian']);
        }
    }
}