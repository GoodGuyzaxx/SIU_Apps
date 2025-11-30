<?php

namespace App\Filament\Resources\Undangans\Pages;

use App\Filament\Resources\Undangans\UndanganResource;
use App\Models\Judul;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists;

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
                ->url(fn () => route('undangan.pdf', $dataId)),
        ];
    }
}

