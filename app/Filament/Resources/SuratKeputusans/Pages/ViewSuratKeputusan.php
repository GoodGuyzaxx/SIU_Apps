<?php

namespace App\Filament\Resources\SuratKeputusans\Pages;

use App\Filament\Resources\SuratKeputusans\SuratKeputusanResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSuratKeputusan extends ViewRecord
{
    protected static string $resource = SuratKeputusanResource::class;

    protected function getHeaderActions(): array
    {

        $dataId = $this->record->id;

        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(SuratKeputusanResource::getUrl('index')),
            EditAction::make(),
            Action::make('Print')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->modalHeading('Preview Surat Keputusan')
                ->modalContent(fn () => view('filament.modals.pdf-preview', [
                    'url' => route('skPDF', $dataId),
                ]))
                ->modalWidth('7xl')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Tutup'),
        ];
    }


}
