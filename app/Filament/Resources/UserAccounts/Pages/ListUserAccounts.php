<?php

namespace App\Filament\Resources\UserAccounts\Pages;

use App\Filament\Resources\UserAccounts\UserAccountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserAccounts extends ListRecords
{
    protected static string $resource = UserAccountResource::class;

    protected ?string $heading = 'Data Pengguna';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label("Tambah Pengguna Baru"),
        ];
    }
}
