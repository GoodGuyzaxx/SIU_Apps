<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUndangan extends ViewRecord
{
    protected static string $resource = UndanganResource::class;

    protected function getHeaderActions(): array
    {
        $dataId = $this->record->id;

        return [

            EditAction::make(),

            Action::make('Print')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn () => route('undangan.pdf', $dataId))
        ];
    }
}
