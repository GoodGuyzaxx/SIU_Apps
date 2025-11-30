<?php

namespace App\Console\Commands;

use App\Models\StatusUndangan;
use App\Models\Undangan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckUndanganStatus extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'undangan:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Status Undangan ketika satu hari tidak ada response dari mahasiswa atau dosen akan gagal menjadwalakan ujian';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking undangan status...');

        // Ambil undangan yang tanggalnya besok (1 hari lagi)
        $batasWaktu = Carbon::now('Asia/Tokyo')->subDay();

        $undanganList = Undangan::where('created_at','<=', $batasWaktu)
            ->where('status_ujian', '!=', 'ready_to_exam')
            ->where('status_ujian', '!=', 'gagal_menjadwalkan_ujian')
            ->where('status_ujian', '!=', 'selesai')
            ->get();

        $this->info("Print Batas Waktu {$batasWaktu}");
        $this->info("Found {$undanganList->count()}  undangan created more than 24 hours ago");

        foreach ($undanganList as $undangan) {
            // Hitung total dosen dan yang sudah hadir
            $totalDosen = StatusUndangan::where('id_undangan', $undangan->id)->count();

            $dosenHadir = StatusUndangan::where('id_undangan', $undangan->id)
                ->where('status_konfirmasi', 'hadir')
                ->count();

            // Jika tidak semua dosen hadir, ubah status menjadi gagal
            if ($totalDosen > 0 && $dosenHadir < $totalDosen) {
                $undangan->update(['status_ujian' => 'gagal_menjadwalkan_ujian']);

                $this->warn("Undangan ID {$undangan->id} status changed to gagal_menjadwalkan_ujian");
            }
        }

        $this->info('Check completed!');
        return 0;
    }
}
