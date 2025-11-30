<?php

namespace App\Observers;

use App\Models\StatusUndangan;
use App\Models\Undangan;

class StatusUndangaObserver
{
    /**
     * Handle the StatusUndangan "created" event.
     */
    public function created(StatusUndangan $statusUndangan): void
    {
        //
        $this->checkAndUpdateStatusUjian($statusUndangan->id_undangan);
    }

    /**
     * Handle the StatusUndangan "updated" event.
     */
    public function updated(StatusUndangan $statusUndangan): void
    {
        //
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

        // Ambil undangan
        $undangan = Undangan::find($idUndangan);

        // Jangan update jika sudah gagal atau selesai
        if (in_array($undangan->status_ujian, ['gagal_menjadwalkan_ujian', 'selesai'])) {
            return;
        }

        // Cek apakah semua dosen dengan id_undangan ini berstatus 'hadir'
        $totalDosen = StatusUndangan::where('id_undangan', $idUndangan)->count();

        $dosenHadir = StatusUndangan::where('id_undangan', $idUndangan)
            ->where('status_konfirmasi', 'Hadir')
            ->count();

        // Jika semua dosen hadir, update status_ujian
        if ($totalDosen > 0 && $totalDosen === $dosenHadir) {
            Undangan::where('id', $idUndangan)
                ->update(['status_ujian' => 'ready_to_exam']);
        }
    }
}
