<?php

namespace App\Filament\Resources\UserAccounts\Schemas;
use Faker\Provider\Text;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        $now = Carbon::now();
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Data akun pengguna dan kredensial login')
                    ->icon('heroicon-o-user-circle')
                    ->collapsible()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Hidden::make('email_verified_at')
                            ->default($now),
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpan(1),

                        TextInput::make('nrp/nidn/npm')
                            ->label('NRP/NIDN/NPM')
                            ->placeholder('Masukkan nomor identitas')
                            ->required()
                            ->unique()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-identification')
                            ->helperText('Nomor identitas sesuai peran')
                            ->columnSpan(1),

                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('user@example.com')
                            ->email()
                            ->unique()
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-envelope')
                            ->suffixIcon('heroicon-m-at-symbol')
                            ->columnSpan(1),

                        TextInput::make('password')
                            ->label('Password')
                            ->placeholder('Minimal 8 karakter')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->prefixIcon('heroicon-m-lock-closed')
                            ->helperText('Kosongkan jika tidak ingin mengubah password')
                            ->columnSpan(1),

                        Select::make('role')
                            ->label('Role / Peran')
                            ->placeholder('Pilih peran pengguna')
                            ->live()
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->prefixIcon('heroicon-m-shield-check')
                            ->options([
                                'dekan' => 'Dekan',
                                'kaprodi' => 'Kepala Program Studi',
                                'akademik' => 'Akademik',
                                'dosen' => 'Dosen',
                                'user' => 'Mahasiswa',
                            ])
                            ->columnSpanFull(),
                    ]),

                // Dosen Section
                Section::make('Data Doesn')
                    ->description('Informasi Lengkap Data Dosen')
                    ->icon('heroicon-o-academic-cap')
                    ->disabled(fn ($get) => $get('role') != 'dosen')
                    ->hidden(fn ($get) => $get('role') != 'dosen')
                    ->relationship('dosen')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Dosen Lengkap Dengna Gelar')
                            ->required()
                            ->prefixIcon('heroicon-m-user')
                            ->maxLength(255),

                        TextInput::make('nidn')
                            ->label('NIDN')
                            ->required()
                            ->prefixIcon('heroicon-m-identification')
                            ->maxLength(50)
                            ->numeric(),

                        TextInput::make('nrp_nip')
                            ->label('NRP / NIP')
                            ->required()
                            ->prefixIcon('heroicon-m-identification')
                            ->maxLength(50)
                            ->numeric(),

                        TextInput::make('inisial_dosen')
                            ->label('Inisial Dosen')
                            ->prefixIcon('heroicon-m-user')
                            ->maxLength(10)
                            ->placeholder('Contoh: JDS'),

                        TextInput::make('ttl')
                            ->label('Tempat, Tanggal Lahir')
                            ->prefixIcon('heroicon-m-identification')
                            ->placeholder('Contoh: Jayapura, 17 Agustus 1980')
                            ->maxLength(255),

                        TextInput::make('nomor_hp')
                            ->label('Nomor HP')
                            ->tel()
                            ->maxLength(20)
                            ->prefixIcon('heroicon-m-phone')
                            ->placeholder('Contoh: 08123456789'),
                    ])
                ,

                Section::make('Data Mahasiswa')
                    ->description('Informasi lengkap data mahasiswa')
                    ->icon('heroicon-o-academic-cap')
                    ->columnSpanFull()
                    ->relationship('mahasiswa')
                    ->disabled(fn ($get) => $get('role') != 'user')
                    ->hidden(fn ($get) => $get('role') != 'user')
                    ->collapsible()
                    ->columns(3)
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->placeholder('Ahmad Budiman')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpan(2),

                        TextInput::make('npm')
                            ->label('NPM')
                            ->placeholder('2023010001')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->numeric()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-identification')
                            ->helperText('Nomor Pokok Mahasiswa')
                            ->columnSpan(1),

                        TextInput::make('nomor_hp')
                            ->label('Nomor HP')
                            ->placeholder('81234567890')
                            ->required()
                            ->tel()
                            ->maxLength(15)
                            ->prefix('+62')
                            ->prefixIcon('heroicon-m-phone')
                            ->helperText('Format: 81234567890')
                            ->columnSpan(1),

                        Select::make('agama')
                            ->label('Agama')
                            ->placeholder('Pilih agama')
                            ->required()
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu',
                            ])
                            ->native(false)
                            ->searchable()
                            ->prefixIcon('heroicon-m-sparkles')
                            ->columnSpan(1),

                        TextInput::make('angkatan')
                            ->label('Angkatan')
                            ->placeholder('2021')
                            ->prefixIcon('heroicon-o-calendar')
                            ->required()
                            ->numeric()
                            ->helperText('Tahun masuk kuliah')
                            ->columnSpan(1),

                        Select::make('jenjang')
                            ->label('Jenjang Pendidikan')
                            ->placeholder('Pilih Jenjang')
                            ->native(false)
                            ->required()
                            ->prefixIcon('heroicon-o-academic-cap')
                            ->options([
                                'sarjana' => 'Sarjana (S1)',
                                'magister' => 'Magister (S2)',
                            ])
                            ->live()
                            ->columnSpan(1),

                        Select::make('kelas')
                            ->label('Kelas')
                            ->placeholder('Pilih Kelas')
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-clock')
                            ->options([
                                'pagi' => 'Kelas Pagi (08:00 - 12:00)',
                                'sore' => 'Kelas Sore (13:00 - 17:00)',
                            ])
                            ->visible(fn ($get) => $get('jenjang') === 'sarjana')
                            ->columnSpan(1),

                        Select::make('program_studi')
                            ->label('Program Studi')
                            ->placeholder('Pilih Program Studi')
                            ->native(false)
                            ->required()
                            ->prefixIcon('heroicon-o-building-library')
                            ->searchable()
                            ->options(
                                function ($get) {
                                    if ($get('jenjang') == 'magister') {
                                        return [
                                            'Magister Hukum' => 'Magister Hukum',
                                            'Kenotariatan' => 'Kenotariatan',
                                        ];
                                    }
                                    return [
                                        'Ilmu Hukum' => 'Ilmu Hukum',
                                    ];
                                }
                            )
                            ->helperText('Pilih program studi yang sesuai')
                            ->columnSpan(1),
                    ]),
            ]);

    }
}
