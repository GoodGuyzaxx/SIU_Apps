<?php

namespace App\Observers;

use App\Models\StatusUndangan;
use App\Models\Undangan;
use App\Services\WhatsappService;

class StatusUndangaObserver
{
    /**
     * Handle the StatusUndangan "created" event.
     */
    public function created(StatusUndangan $statusUndangan): void
    {
        $this->checkAndUpdateStatusUjian($statusUndangan->id_undangan);
    }

    /**
     * Handle the StatusUndangan "updated" event.
     */
    public function updated(StatusUndangan $statusUndangan): void
    {
        $this->checkAndUpdateStatusUjian($statusUndangan->id_undangan);
    }

    /**
     * Handle the StatusUndangan "deleted" event.
     */
    public function deleted(StatusUndangan $statusUndangan): void
    {
        //
    }

    /**
     * Handle the StatusUndangan "restored" event.
     */
    public function restored(StatusUndangan $statusUndangan): void
    {
        //
    }

    /**
     * Handle the StatusUndangan "force deleted" event.
     */
    public function forceDeleted(StatusUndangan $statusUndangan): void
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