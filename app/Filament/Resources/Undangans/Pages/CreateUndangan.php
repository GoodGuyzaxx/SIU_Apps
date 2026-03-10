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

        // Ambil dosen penguji 1 dari judul
        $pengujiSatuId = $judul->penguji_satu;

        if (!$pengujiSatuId) {
            Notification::make()
                ->title('Peringatan')
                ->body('Dosen Penguji 1 belum ditetapkan. ACC kesiapan tidak dapat dikirim.')
                ->warning()
                ->send();
            return;
        }

        // Set status undangan ke "menunggu_acc" (belum dijadwalkan secara resmi)
        $record->update(['status_ujian' => 'menunggu_acc']);

        // Buat record ACC kesiapan ujian
        $acc = AccKesiapanUjian::create([
            'id_undangan' => $record->id,
            'id_dosen' => $pengujiSatuId,
            'status' => 'pending',
        ]);

        // Kirim notifikasi WA ke Penguji 1
        $waService = new WhatsappService();
        $sent = $waService->sendAccKesiapanRequest($acc);

        if ($sent) {
            Notification::make()
                ->title('Undangan Dibuat & ACC Dikirim')
                ->body('Permintaan ACC kesiapan ujian telah dikirim ke Penguji 1 melalui WhatsApp.')
                ->success()
                ->send();
        }
        else {
            Notification::make()
                ->title('Undangan Dibuat')
                ->body('Undangan berhasil dibuat, namun pengiriman ACC ke WhatsApp gagal. Silakan kirim manual.')
                ->warning()
                ->send();
        }
    }
}