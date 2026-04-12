<?php

namespace App\Console\Commands;

use App\Models\AccKesiapanUjian;
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
            $totalDosen = AccKesiapanUjian::where('id_undangan', $undangan->id)->count();
            $dosenList = AccKesiapanUjian::where('id_undangan', $undangan->id)->get();

            $dosenHadir = AccKesiapanUjian::where('id_undangan', $undangan->id)
                ->where('status', 'disetujui')
                ->count();


            if ($totalDosen > 0 && $dosenHadir < $totalDosen) {
                $undangan->update([
                    'status_ujian' => 'gagal_menjadwalkan_ujian',
                ]);

                $this->warn("Undangan ID {$undangan->id} status changed to gagal_menjadwalkan_ujian");
            }

            foreach ($dosenList as $accKesiapan){
                if ($accKesiapan->status == 'pending'){
                    $accKesiapan->update([
                        'status' => 'ditolak',
                        'alasan_penolakan' => 'Dosen Tidak Memberikan Response',
                        'responded_at' => now(),
                    ]);

                    $this->warn("Undangan ID {$undangan->id} catatan penolakan diupdate");
                }
            }
        }

        $this->info('Check completed!');
        return 0;
    }
}
