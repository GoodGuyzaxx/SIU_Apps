<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Models\AccKesiapanUjian;
use App\Models\StatusUndangan;
use App\Services\WhatsappService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUndangan extends CreateRecord
{
    protected static string $resource = UndanganResource::class;

    protected ?string $heading = 'Buat Undangan';

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResourceUrl('index');
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $judul = $record->judul;

        // Set status undangan ke "menunggu_acc"
        $record->update(['status_ujian' => 'menunggu_acc']);

        // Ambil semua status undangan (dosen yang terlibat)
        $statusList = StatusUndangan::where('id_undangan', $record->id)->get();

        if ($statusList->isEmpty()) {
            Notification::make()
                ->title('Peringatan')
                ->body('Tidak ada dosen yang ditetapkan. ACC kesiapan tidak dapat dikirim.')
                ->warning()
                ->send();
            return;
        }

        $waService = new WhatsappService();
        $sentCount = 0;
        $failCount = 0;

        foreach ($statusList as $status) {
            $dosen = $status->dosen;
            if (!$dosen) continue;

            // Buat record ACC kesiapan ujian untuk setiap dosen
            $acc = AccKesiapanUjian::create([
                'id_undangan' => $record->id,
                'id_dosen' => $dosen->id,
                'role' => $status->role,
                'status' => 'pending',
            ]);

            // Kirim notifikasi WA ke dosen
            if ($dosen->nomor_hp) {
                $sent = $waService->sendAccKesiapanRequest($acc);
                if ($sent) {
                    $sentCount++;
                } else {
                    $failCount++;
                }
            } else {
                $failCount++;
            }
        }

        if ($sentCount > 0 && $failCount === 0) {
            Notification::make()
                ->title('Undangan Dibuat & ACC Dikirim')
                ->body("Permintaan ACC kesiapan ujian telah dikirim ke {$sentCount} dosen melalui WhatsApp.")
                ->success()
                ->send();
        } elseif ($sentCount > 0 && $failCount > 0) {
            Notification::make()
                ->title('Undangan Dibuat')
                ->body("ACC terkirim ke {$sentCount} dosen, gagal {$failCount} dosen. Periksa nomor HP dosen.")
                ->warning()
                ->send();
        } else {
            Notification::make()
                ->title('Undangan Dibuat')
                ->body('Undangan berhasil dibuat, namun semua pengiriman ACC gagal. Silakan kirim manual.')
                ->warning()
                ->send();
        }
    }
}