<?php

namespace App\Filament\Pages;

use App\Models\Prodi;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('prodi_id')
                    ->label('Program Studi')
                    ->options(fn () => Prodi::orderBy('nama_prodi')->pluck('nama_prodi', 'id')->toArray())
                    ->placeholder('Semua Prodi')
                    ->searchable()
                    ->preload(),
            ]);
    }
}
