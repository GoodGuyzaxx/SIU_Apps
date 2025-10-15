<?php

namespace App\Filament\Resources\Undangans\Schemas;

use App\Models\Judul;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UndanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_judul')
                    ->label('Judul')
                    ->options(Judul::query()->with('mahasiswa')->get()->mapWithKeys(function ($judul) {
                        $mahasiswaNama = $judul->mahasiswa ? $judul->mahasiswa->nama : 'Tidak ada mahasiswa';
                        return [$judul->id => $judul->judul . ' - ' . $mahasiswaNama . ' - ' . $judul->mahasiswa->npm];
                    }))
                ->searchable(),

                TextInput::make('nomor')
                    ->required(),
                TextInput::make('perihal')
                    ->required(),

                DatePicker::make('tanggal_hari')
                    ->required(),
                TimePicker::make('waktu')
                    ->required(),
                Textarea::make('tempat')
                    ->required(),
            ]);
    }
}
