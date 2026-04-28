<?php

namespace App\Filament\Resources\Juduls\Schemas;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\TahunAkademik;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class JudulForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Judul & Mahasiswa')
                    ->description('Masukkan detail mengenai judul skripsi dan mahasiswa yang mengajukan.')
                    ->schema([
                        Select::make('id_mahasiswa')
                            ->label('Mahasiswa')
                            ->options(Mahasiswa::query()->pluck('nama', 'id'))
                            ->required()
                            ->searchable(),

                        Select::make('minat')
                            ->label('Minat Kekhususan') // Typo diperbaiki
                            ->required()
                            ->options([
                                "HTN" => "Hukum Tata Negara (HTN)",
                                "Hukum Pidana" => "Hukum Pidana",
                                "Hukum Perdata" => "Hukum Perdata",
                            ]),

                        Textarea::make('judul')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('tahun_akademik_id')
                            ->label('Tahun Akademik')
                            ->native(false)
                            ->options(
                                TahunAkademik::query()
                                    ->pluck(DB::raw("CONCAT('[',takad,'-', priode,']', '-',tahun)"), 'id')
                            )

                    ])->columns(2),

                Section::make('Tim Dosen')
                    ->description('Pilih dosen pembimbing dan penguji untuk judul skripsi ini.')
                    ->schema([
                        Select::make('pembimbing_satu')
                            ->label('Pembimbing Pertama')
                            ->options(Dosen::query()->pluck('nama', 'id'))
                            ->searchable(),

                        Select::make('pembimbing_dua')
                            ->label('Pembimbing Kedua')
                            ->options(Dosen::query()->pluck('nama', 'id'))
                            ->searchable(),

                        Select::make('penguji_satu')
                            ->label('Penguji Pertama')
                            ->options(Dosen::query()->pluck('nama', 'id'))
                            ->searchable(),

                        Select::make('penguji_dua')
                            ->label('Penguji Kedua') // Label diperbaiki
                            ->options(Dosen::query()->pluck('nama', 'id'))
                            ->searchable(),
                    ])->columns(2),

            ]);
    }
}
