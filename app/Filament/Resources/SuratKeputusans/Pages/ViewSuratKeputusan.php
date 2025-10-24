<?php

namespace App\Filament\Resources\SuratKeputusans\Pages;

use App\Filament\Resources\SuratKeputusans\SuratKeputusanResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;

class ViewSuratKeputusan extends ViewRecord
{
    protected static string $resource = SuratKeputusanResource::class;

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
                    ->url(fn () => route('skPDF', $dataId)),
                Action::make('Print Dengan Tanda Tangan')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->hidden(auth()->user()->role != 'admin')
                    ->url(fn () => route('skttdPDF', $dataId))
            ])
            ->dropdownWidth(Width::Large),
        ];
    }


}
