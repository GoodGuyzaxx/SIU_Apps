<?php

namespace App\Filament\Resources\Undangans\Schemas;

use App\Models\Dosen;
use App\Models\Judul;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
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
                            ->options(Judul::with('mahasiswa')->get()->mapWithKeys(function ($judul) {
                                $mahasiswaInfo = 'Mahasiswa tidak terhubung';
                                if ($judul->mahasiswa) {
                                    $mahasiswaInfo = "{$judul->mahasiswa->nama} - {$judul->mahasiswa->npm}";
                                }
                                return [$judul->id => "{$judul->judul} - {$mahasiswaInfo}"];
                            }))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if (blank($state)) {
                                    // Reset repeater jika tidak ada judul yang dipilih
                                    $set('statusUndangan', [
                                        ['role' => 'pembimbing_satu'],
                                        ['role' => 'pembimbing_dua'],
                                        ['role' => 'penguji_satu'],
                                        ['role' => 'penguji_dua'],
                                    ]);
                                    return;
                                }

                                $judul = Judul::find($state);

                                if (!$judul) return;

                                $dosenData = [
                                    ['id_dosen' => $judul->pembimbing_satu, 'role' => 'pembimbing_satu', 'status_konfirmasi' => 'belum dikonfirmasi'],
                                    ['id_dosen' => $judul->pembimbing_dua, 'role' => 'pembimbing_dua','status_konfirmasi' => 'belum dikonfirmasi'],
                                    ['id_dosen' => $judul->penguji_satu, 'role' => 'penguji_satu','status_konfirmasi' => 'belum dikonfirmasi'],
                                    ['id_dosen' => $judul->penguji_dua, 'role' => 'penguji_dua','status_konfirmasi' => 'belum dikonfirmasi'],
                                ];
                                $set('statusUndangan', $dosenData);
                            })
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // Section 2: Detail Surat Undangan
                Section::make('Detail Surat Undangan')
                    ->schema([
                        TextInput::make('nomor')
                            ->label('Nomor Surat')
                            ->numeric()
                            ->placeholder('Contoh 001')
                            ->minValue(0)
                            ->required(),

                        Select::make('perihal')
                            ->label('Perihal Undangan')
                            ->required()
                            ->native(false)
                            ->options([
                                'Undangan Ujian Proposal' => 'Undangan Ujian Proposal',
                                'Undangan Ujian Skripsi' => 'Undangan Ujian Skripsi'
                            ])

                    ])
                    ->columns(2),

                // Section 3: Jadwal Ujian
                Section::make('Jadwal Ujian Dan Status Ujian')

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

                        Select::make('tempat')
                            ->label('Tempat Ujian')
                            ->required()
                            ->native(false)
                            ->live()
                            ->options([
                                'Lantai II, Ruang Pasca Sarjana.' => 'Lantai II, Ruang Pasca Sarjana.',
                                'online' => "Zoom Meeting"
                            ])
                            ->columnSpanFull(),

                        TextInput::make('meeting_id')
                            ->label('Meeting ID')
                            ->visible(fn($get) => $get('tempat') === 'online'),

                        TextInput::make('passcode')
                            ->visible(fn($get) => $get('tempat') === 'online')
                            ->label('Passcode'),

                        Select::make('status_ujian')
                            ->hiddenOn('create')
                            ->label('Status Ujian')
                            ->helperText('Opsional')
                            ->default('dijadwalkan')
                            ->columnSpanFull()
                            ->options([
                                'dijadwalkan' => 'Di Jadwalkan',
                                'draft_uploaded' => 'Draft Diupload',
                                'ready_to_exam' => 'Siap Ujian',
                                'selesai' => 'Selesai'
                            ])
                    ])
                    ->columns(2),

                // Section 4: Upload Dokumen
                Section::make('Dokumen')
                    ->hiddenOn('create')
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
                Section::make('Penugasan Dosen Pembimbing Dan Penguji')
                    ->columnSpanFull()

                    ->schema([
                        Repeater::make('statusUndangan')
                            ->relationship()
                            ->schema([
                                Select::make('id_dosen')
                                    ->label('Nama Dosen')
                                    ->options(Dosen::pluck('nama', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->reactive()
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
                                    ->default('belum dikonfirmasi')
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
                            ->grid(2)
                            ->maxItems(4)
                            ->defaultItems(4)
                            ->deletable(false)
                            ->addable(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
