<?php

namespace App\Filament\Resources\Undangans\Schemas;

use App\Models\Judul;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Monolog\Handler\SlackHandler;

class UndanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section 1: Informasi Judul
                Section::make('Informasi Judul')
                    ->schema([
                        Select::make('id_judul')
                            ->label('Judul')
                            ->options(Judul::query()->with('mahasiswa')->get()->mapWithKeys(function ($judul) {
                                $mahasiswaNama = $judul->mahasiswa ? $judul->mahasiswa->nama : 'Tidak ada mahasiswa';
                                return [$judul->id => $judul->judul . ' - ' . $mahasiswaNama . ' - ' . $judul->mahasiswa->npm];
                            }))
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Section 2: Detail Surat Undangan
                Section::make('Detail Surat Undangan')
                    ->schema([
                        TextInput::make('nomor')
                            ->label('Nomor Surat')
                            ->required()
                            ->placeholder('Contoh: 001/UN/2024'),

                        TextInput::make('perihal')
                            ->label('Perihal Undangan')
                            ->required()
                            ->placeholder('Contoh: Undangan Ujian Proposal'),
                    ])
                    ->columns(2),

                // Section 3: Jadwal Ujian
                Section::make('Jadwal Ujian')
                    ->schema([
                        DatePicker::make('tanggal_hari')
                            ->label('Tanggal')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->placeholder('Pilih tanggal'),

                        TimePicker::make('waktu')
                            ->label('Waktu')
                            ->required()
                            ->seconds(false)
                            ->native(false)
                            ->placeholder('Contoh: 09:00'),

                        Textarea::make('tempat')
                            ->label('Tempat Ujian')
                            ->required()
                            ->rows(3)
                            ->placeholder('Contoh: Ruang Sidang 1, Gedung FMIPA')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Section 4: Upload Dokumen
                Section::make('Dokumen')
                    ->schema([
                        FileUpload::make('softcopy_file_path')
                            ->label('Draft Proposal atau Skripsi (Opsional)')
                            ->directory('uploaded-draft')
                            ->disk('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240) // 10MB
                            ->moveFiles()
                            ->openable()
                            ->downloadable()
                            ->helperText('Upload file PDF (maksimal 10MB)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Section 5: Penugasan Dosen
                Section::make('Penugasan Dosen')
                    ->schema([
                        Repeater::make('statusUndangan')
                            ->label('Daftar Dosen')
                            ->relationship()
                            ->schema([
                                Select::make('id_dosen')
                                    ->label('Nama Dosen')
                                    ->options(User::where('role', 'dosen')->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->placeholder('Pilih dosen'),

                                Select::make('role')
                                    ->label('Peran')
                                    ->options([
                                        'pembimbing_satu' => 'Pembimbing 1',
                                        'pembimbing_dua' => 'Pembimbing 2',
                                        'penguji_satu' => 'Penguji 1',
                                        'penguji_dua' => 'Penguji 2'
                                    ])
                                    ->required()
                                    ->placeholder('Pilih peran'),
                                Select::make('status_konfirmasi')
                                    ->label('Konfirmasi Kehadiran')
                                    ->helperText('Opsional')
                                    ->options([
                                        'Hadir' => 'Hadir',
                                        'Tidak Hadir' => 'Tidak Hadir',
                                        'belum dikonfirmasi' => 'Belum Dikonfirmasi'
                                    ])
                                    ->default('belum dikonfirmasi')
                                    ->placeholder('Pilih status kehadiran'),
                                Textarea::make('alasan_penolakan')
                                    ->label('Alasan Penolakan')
                                    ->helperText('Opsional')
                                    ->rows(2)

                            ])
                            ->minItems(3)
                            ->maxItems(4)
                            ->defaultItems(4)
                            ->addActionLabel('Tambah Dosen')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string =>
                                User::find($state['id_dosen'])?->name ?? 'Dosen baru'
                            )
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->columnSpanFull()
                    ->description('Minimal 4 dosen harus ditugaskan (kombinasi pembimbing dan penguji)'),
            ]);
    }
}
