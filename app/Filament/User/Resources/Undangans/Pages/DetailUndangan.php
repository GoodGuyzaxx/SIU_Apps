<?php

namespace App\Filament\User\Resources\Undangans\Pages;

use App\Filament\User\Resources\Undangans\UndanganResource;
use App\Models\AccKesiapanUjian;
use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\Undangan;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class DetailUndangan extends Page
{
    use InteractsWithRecord;

    protected static string $resource = UndanganResource::class;

    protected string $view = 'filament.user.resources.undangans.pages.detail-undangan';

    public array  $softcopy     = [];
    public bool   $kesiapandata = false;
    public ?object $undangan    = null;
    public $status              = null;


    /* ──────────────────────────────────────────────────────────────────────
     |  Mount
     └─────────────────────────────────────────────────────────────────────*/
    public function mount(int | string $record): void
    {
        $idMahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();

        if (! $idMahasiswa) {
            Notification::make()
                ->title('Silakan Lengkapi Data Profile Terlebih Dahulu')
                ->warning()
                ->send();
            $this->redirect(route('filament.user.pages.user-setting'));
            return;
        }

        $dataJudul = Judul::where('id_mahasiswa', $idMahasiswa->id)->first();

        if (! $dataJudul) {
            Notification::make()->title('Data Judul tidak ditemukan')->danger()->send();
            $this->redirect(filament()->getHomeUrl());
            return;
        }

        $this->record   = Undangan::find($record);

        if (! $this->record) {
            Notification::make()->title('Data Undangan tidak ditemukan')->danger()->send();
            $this->redirect(filament()->getHomeUrl());
            return;
        }

        $this->undangan = $this->record;

        // Eager-load dosen.user agar nama bisa diambil tanpa N+1
        $this->status = AccKesiapanUjian::with('dosen.user')
            ->where('id_undangan', $this->undangan->id)
            ->get();
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Schema: Informasi Mahasiswa
     └─────────────────────────────────────────────────────────────────────*/
    public function infoMahasiswa(Schema $schema): Schema
    {
        $dataMhs = Mahasiswa::where('id_user', auth()->user()->id)->first();

        return $schema
            ->record($dataMhs)
            ->schema([
                Section::make('Informasi Mahasiswa')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                // ── Identitas Diri ──────────────────────────
                                Section::make('Identitas Diri')
                                    ->icon('heroicon-o-identification')
                                    ->schema([
                                        TextEntry::make('nama')
                                            ->label('Nama Lengkap')
                                            ->icon('heroicon-m-user')
                                            ->copyable()
                                            ->weight(FontWeight::SemiBold)
                                            ->size(TextSize::Large),

                                        TextEntry::make('npm')
                                            ->label('NPM')
                                            ->icon('heroicon-m-identification')
                                            ->copyable()
                                            ->badge()
                                            ->color('primary'),

                                        TextEntry::make('angkatan')
                                            ->label('Angkatan')
                                            ->icon('heroicon-m-calendar-days')
                                            ->badge()
                                            ->color('info'),
                                    ])
                                    ->columnSpan(1),

                                // ── Informasi Akademik ──────────────────────
                                Section::make('Informasi Akademik')
                                    ->icon('heroicon-o-academic-cap')
                                    ->schema([
                                        TextEntry::make('prodi.nama_prodi')
                                            ->label('Program Studi')
                                            ->icon('heroicon-m-academic-cap')
                                            ->weight(FontWeight::Medium),

                                        TextEntry::make('jenjang')
                                            ->label('Jenjang Pendidikan')
                                            ->icon('heroicon-m-arrow-trending-up')
                                            ->badge()
                                            ->color('success'),

                                        TextEntry::make('kelas')
                                            ->label('Kelas')
                                            ->icon('heroicon-m-building-library')
                                            ->badge()
                                            ->color('warning'),
                                    ])
                                    ->columnSpan(1),
                            ]),

                        // ── Kontak ─────────────────────────────────────────
                        Section::make('Informasi Kontak & Pribadi')
                            ->icon('heroicon-o-phone')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('nomor_hp')
                                    ->label('Nomor HP')
                                    ->icon('heroicon-m-phone')
                                    ->copyable()
                                    ->url(fn ($record) => $record
                                        ? 'https://wa.me/62' . ltrim($record->nomor_hp, '0')
                                        : null)
                                    ->color('success'),

                                TextEntry::make('agama')
                                    ->label('Agama')
                                    ->icon('heroicon-m-hand-raised'),
                            ])
                            ->collapsible(),
                    ]),
            ]);
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Schema: Info Judul & Tim Dosen
     └─────────────────────────────────────────────────────────────────────*/
    public function infoData(Schema $schema): Schema
    {
        $idMahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();
        $dataJudul   = Judul::with([
            'pembimbingSatu',
            'pembimbingDua',
            'pengujiSatu',
            'pengujiDua',
        ])->where('id_mahasiswa', $idMahasiswa->id)->first();

        return $schema
            ->record($dataJudul)
            ->components([
                // ── Judul Penelitian ────────────────────────────────────────
                Section::make('Informasi Judul')
                    ->icon('heroicon-o-book-open')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('judul')
                            ->label('Judul Penelitian')
                            ->icon('heroicon-m-document-text')
                            ->weight(FontWeight::SemiBold)
                            ->size(TextSize::Large)
                            ->columnSpanFull()
                            ->placeholder('Belum ada judul'),

                        TextEntry::make('minat')
                            ->label('Bidang Minat')
                            ->icon('heroicon-m-light-bulb')
                            ->badge()
                            ->color('info')
                            ->placeholder('Belum ditentukan'),

                        TextEntry::make('jenis')
                            ->label('Jenis Penelitian')
                            ->icon('heroicon-m-magnifying-glass')
                            ->badge()
                            ->color('primary')
                            ->placeholder('Belum ditentukan'),
                    ])
                    ->collapsible(),

                // ── Tim Pembimbing ──────────────────────────────────────────
                Section::make('Tim Pembimbing')
                    ->icon('heroicon-o-user-group')
                    ->description('Dosen pembimbing yang ditugaskan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('pembimbingSatu.nama')
                            ->label('Pembimbing 1')
                            ->icon('heroicon-m-user-circle')
                            ->weight(FontWeight::Medium)
                            ->placeholder('Belum ditentukan')
                            ->color('success'),

                        TextEntry::make('pembimbingDua.nama')
                            ->label('Pembimbing 2')
                            ->icon('heroicon-m-user-circle')
                            ->weight(FontWeight::Medium)
                            ->placeholder('Belum ditentukan')
                            ->color('success'),
                    ])
                    ->collapsible(),

                // ── Tim Penguji ─────────────────────────────────────────────
                Section::make('Tim Penguji')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('Dosen penguji yang ditugaskan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('pengujiSatu.nama')
                            ->label('Penguji 1')
                            ->icon('heroicon-m-academic-cap')
                            ->weight(FontWeight::Medium)
                            ->placeholder('Belum ditentukan')
                            ->color('warning'),

                        TextEntry::make('pengujiDua.nama')
                            ->label('Penguji 2')
                            ->icon('heroicon-m-academic-cap')
                            ->weight(FontWeight::Medium)
                            ->placeholder('Belum ditentukan')
                            ->color('warning'),
                    ])
                    ->collapsible(),
            ]);
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Schema: Status Undangan & Konfirmasi Dosen
     |  FIX: gunakan dosen->nama bukan user->name
     └─────────────────────────────────────────────────────────────────────*/
    public function infoStatusUndangan(Schema $schema): Schema
    {
        $sections  = [];
        $firstData = $this->status->first();

        // Label status ujian yang rapi
        $statusLabel = match ($firstData?->undangan?->status_ujian) {
            'dijadwalkan'              => 'Dijadwalkan',
            'draft_uploaded'           => 'Draft Diupload',
            'ready_to_exam'            => 'Siap Ujian',
            'selesai'                  => 'Ujian Selesai',
            'gagal_menjadwalkan_ujian' => 'Gagal Menjadwalkan',
            default                    => ucwords(str_replace('_', ' ', $firstData?->undangan?->status_ujian ?? '-')),
        };

        $statusColor = match ($firstData?->undangan?->status_ujian) {
            'selesai'                  => 'success',
            'gagal_menjadwalkan_ujian' => 'danger',
            'ready_to_exam'            => 'info',
            default                    => 'warning',
        };

        foreach ($this->status as $status) {
            $label = $this->resolveRoleLabel($status->role);

            // FIX: gunakan dosen->nama, fallback ke dosen->user->name
            $namaDosen = $status->dosen?->nama
                ?? $status->dosen?->user?->name
                ?? 'Belum diketahui';

            $sections[] = Section::make('Dosen ' . $label)
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    TextEntry::make('nama_' . $status->id)
                        ->label('Nama Dosen')
                        ->default($namaDosen)
                        ->weight(FontWeight::Bold)
                        ->size(TextSize::Large),

                    TextEntry::make('status_' . $status->id)
                        ->label('Status Konfirmasi')
                        ->default($status->status ?? 'pending')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'disetujui' => 'success',
                            'ditolak'   => 'danger',
                            default     => 'warning',
                        }),

                    TextEntry::make('alasan_' . $status->id)
                        ->label('Alasan Penolakan')
                        ->default($status->alasan_penolakan ?? '-')
                        ->visible(fn () => $status->status === 'ditolak'),
                ]);
        }

        return $schema->components([
            Section::make('Status Undangan')
                ->icon('heroicon-o-clipboard-document-list')
                ->schema([
                    // ── Banner status ujian ─────────────────────────────────
                    TextEntry::make('status_ujian_display')
                        ->label('Status Ujian Saat Ini')
                        ->default($statusLabel)
                        ->badge()
                        ->color($statusColor)
                        ->size(TextSize::Large)
                        ->weight(FontWeight::Bold),

                    // ── Grid kartu per dosen ────────────────────────────────
                    Grid::make(2)
                        ->schema($sections),
                ]),
        ]);
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Schema: Form Upload Draft
     └─────────────────────────────────────────────────────────────────────*/
    public function uploadForm(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Upload Draft Naskah')
                ->icon('heroicon-o-arrow-up-tray')
                ->description('Upload file PDF draft proposal atau skripsi sebelum ujian dilaksanakan.')
                ->schema([
                    FileUpload::make('softcopy_file_path')
                        ->label('Draft Proposal atau Skripsi')
                        ->directory('uploaded-draft')
                        ->disk('public')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(10240)
                        ->moveFiles()
                        ->helperText('Format PDF, maksimal 10 MB')
                        ->columnSpanFull()
                        ->required()
                        ->statePath('softcopy'),

                    Checkbox::make('kesiapan')
                        ->label('Dengan ini, saya menyatakan kesiapan saya untuk menghadiri ujian.')
                        ->accepted()
                        ->required()
                        ->statePath('kesiapandata'),
                ]),
        ]);
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Action: Konfirmasi Upload
     └─────────────────────────────────────────────────────────────────────*/
    public function konfirmasi(): void
    {
        $idMahasiswa  = Mahasiswa::where('id_user', auth()->user()->id)->first();
        $dataJudul    = Judul::where('id_mahasiswa', $idMahasiswa->id)->first();
        $dataUndangan = Undangan::where('id_judul', $dataJudul->id)->first();

        $data = $this->uploadForm->getState();

        $dataUndangan->update([
            'softcopy_file_path' => $data['softcopy'],
            'status_ujian'       => 'draft_uploaded',
        ]);

        Notification::make()
            ->title('Draft berhasil diupload!')
            ->body('Silakan tunggu konfirmasi lebih lanjut dari tim dosen.')
            ->success()
            ->send();

        $this->refresh();
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Helper: terjemahkan role ke label yang rapi
     └─────────────────────────────────────────────────────────────────────*/
    private function resolveRoleLabel(?string $role): string
    {
        return match ($role) {
            'pembimbing_satu', 'pembimbing1' => 'Pembimbing 1',
            'pembimbing_dua',  'pembimbing2' => 'Pembimbing 2',
            'penguji_satu',    'penguji1'    => 'Penguji 1',
            'penguji_dua',     'penguji2'    => 'Penguji 2',
            default                          => ucwords(str_replace('_', ' ', $role ?? '-')),
        };
    }
}
