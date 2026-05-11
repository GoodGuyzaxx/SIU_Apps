<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Models\AccKesiapanUjian;
use App\Models\Dosen;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

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

        // Set status undangan ke "menunggu_acc"
        $record->update(['status_ujian' => 'menunggu_acc']);

        // Bangun daftar dosen dari data judul
        $dosenList = collect();
        $judul = $record->judul;

        if ($judul->pembimbing_satu) {
            $dosenList->push(['id_dosen' => $judul->pembimbing_satu, 'role' => 'pembimbing_satu']);
        }
        if ($judul->pembimbing_dua) {
            $dosenList->push(['id_dosen' => $judul->pembimbing_dua, 'role' => 'pembimbing_dua']);
        }
        if ($judul->penguji_satu) {
            $dosenList->push(['id_dosen' => $judul->penguji_satu, 'role' => 'penguji_satu']);
        }
        if ($judul->penguji_dua) {
            $dosenList->push(['id_dosen' => $judul->penguji_dua, 'role' => 'penguji_dua']);
        }

        if ($dosenList->isEmpty()) {
            Notification::make()
                ->title('Peringatan')
                ->body('Tidak ada dosen yang ditetapkan untuk undangan ini.')
                ->warning()
                ->send();
            return;
        }

        foreach ($dosenList as $item) {
            $dosen = Dosen::find($item['id_dosen']);
            if (!$dosen) continue;

            // Cek apakah ACC sudah ada (hindari duplikat)
            $existing = AccKesiapanUjian::where('id_undangan', $record->id)
                ->where('id_dosen', $dosen->id)
                ->first();

            if ($existing) continue;

            // Buat record ACC kesiapan ujian untuk setiap dosen
            AccKesiapanUjian::create([
                'id_undangan' => $record->id,
                'id_dosen'    => $dosen->id,
                'role'        => $item['role'],
                'status'      => 'pending',
            ]);
        }

        Notification::make()
            ->title('Undangan Berhasil Dibuat')
            ->body('Data ACC kesiapan ujian telah disiapkan. Silakan buka detail undangan untuk mengirim pesan WhatsApp ke dosen dan mahasiswa.')
            ->success()
            ->send();
    }
}
