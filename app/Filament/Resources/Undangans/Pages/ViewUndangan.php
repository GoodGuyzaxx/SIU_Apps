<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Models\Undangan;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\Width;

class ViewUndangan extends ViewRecord
{
    protected static string $resource = UndanganResource::class;

    protected function getHeaderActions(): array
    {
        $dataId = $this->record->id;

        return [
            EditAction::make(),
            ActionGroup::make([
                Action::make('Print')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->hidden(auth()->user()->role != 'admin')
                    ->url(fn () => route('undangan.pdf', $dataId)),
                Action::make('Print Dengan Tanda Tangan')
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->hidden(auth()->user()->role != 'admin')
                    ->url(fn () => route('undangan.ttd.pdf', $dataId)),
            ])
            ->dropdownWidth(Width::Large)
        ];
    }


}

