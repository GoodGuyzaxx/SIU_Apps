<?php

namespace App\Filament\User\Resources\Pengajuans\Pages;

use App\Filament\User\Resources\Pengajuans\PengajuanResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePengajuan extends CreateRecord
{
    protected static string $resource = PengajuanResource::class;

    protected static bool $canCreateAnother = false;


    protected function getCreatedNotification(): ?Notification
    {
        $role = ['admin','akademik','kaprodi','dekan'];
        $user = User::whereIn('role', $role)->get();

        return Notification::make()
            ->success()
            ->title('Pengajuan Judul Baru')
            ->body('Nama '.$this->record->mahasiswa->nama.' '.$this->record->mahasiswa->npm)
            ->sendToDatabase($user);
    }

}
