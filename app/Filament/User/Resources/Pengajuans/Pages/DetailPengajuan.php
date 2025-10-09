<?php

namespace App\Filament\User\Resources\Pengajuans\Pages;

use App\Filament\User\Resources\Pengajuans\PengajuanResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class DetailPengajuan extends Page
{

    use InteractsWithRecord;

    protected static string $resource = PengajuanResource::class;

    protected string $view = 'filament.user.resources.pengajuans.pages.detail-pengajuan';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
//        dd($this->record);
    }
}
