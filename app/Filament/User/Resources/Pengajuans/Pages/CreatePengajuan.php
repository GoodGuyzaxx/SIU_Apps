<?php

namespace App\Filament\User\Resources\Pengajuans\Pages;

use App\Filament\User\Resources\Pengajuans\PengajuanResource;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\UsulanJudul;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePengajuan extends CreateRecord
{
    protected static string $resource = PengajuanResource::class;

    protected static bool $canCreateAnother = false;


    protected function getCreatedNotification(): ?Notification
    {
        $data = auth()->user();

        $user = User::where('role', 'admin')->get();

        return Notification::make()
            ->success()
            ->title('Pengajuan Judul Baru')
            ->body('nama '.$this->record->mahasiswa->nama.' '.$this->record->mahasiswa->npm)
            ->sendToDatabase($user);
    }

}
