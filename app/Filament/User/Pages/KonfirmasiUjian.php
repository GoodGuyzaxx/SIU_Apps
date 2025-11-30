<?php

namespace App\Filament\User\Pages;

use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\StatusUndangan;
use App\Models\Undangan;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use http\Exception;
use Illuminate\Support\Facades\Auth;

class KonfirmasiUjian extends Page
{
    protected string $view = 'filament.user.pages.konfirmasi-ujian';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-check';

    protected static ?int $navigationSort = 6;

    public array $softcopy = [];
    public bool $kesiapandata = false;

    public ?object $undangan = null;

    public $status =null;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function mount(): void
    {
        $idMahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();
        $dataJudul = Judul::where('id_mahasiswa', $idMahasiswa->id)->first();
        $dataUndangan = Undangan::where('id_judul', $dataJudul->id)->first();

        $this->undangan = $dataUndangan;

        $this->status = StatusUndangan::where('id_undangan', $this->undangan->id)->get();
    }

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
                                // Identitas Diri
                                Section::make('Identitas Diri')
                                    ->icon('heroicon-o-identification')
                                    ->schema([
                                        TextEntry::make('nama')
                                            ->label('Nama Lengkap')
                                            ->icon('heroicon-m-user')
                                            ->copyable()
                                            ->weight('medium')
                                            ->size('lg'),
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

                                // Informasi Akademik
                                Section::make('Informasi Akademik')
                                    ->icon('heroicon-o-academic-cap')
                                    ->schema([
                                        TextEntry::make('program_studi')
                                            ->label('Program Studi')
                                            ->icon('heroicon-m-academic-cap')
                                            ->weight('medium'),
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

                        // Informasi Kontak
                        Section::make('Informasi Kontak & Pribadi')
                            ->icon('heroicon-o-phone')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('nomor_hp')
                                    ->label('Nomor HP')
                                    ->icon('heroicon-m-phone')
                                    ->copyable()
                                    ->url(fn ($record) => $record ? 'https://wa.me/62' . ltrim($record->nomor_hp, '0') : null)
                                    ->color('success'),
                                TextEntry::make('agama')
                                    ->label('Agama')
                                    ->icon('heroicon-m-hand-raised'),
                            ])
                            ->collapsible(),
                    ])
            ]);
    }

    public function infoStatusUndangan(Schema $schema): Schema
    {
        $sections = [];

        foreach ($this->status as $status) {

            // Mapping nama section berdasarkan role di tabel
            // Sesuaikan dengan value sebenarnya di database kamu
            $label = match ($status->role) {
                'pembimbing_satu', 'pembimbing1' => 'Pembimbing 1',
                'pembimbing_dua', 'pembimbing2' => 'Pembimbing 2',
                'penguji_satu', 'penguji1'       => 'Penguji 1',
                'penguji_dua', 'penguji2'       => 'Penguji 2',
                default                       => '-',
            };

            $sections[] = Section::make('Dosen '.$label)
                ->schema([
                    TextEntry::make('nama_' . $status->id)
                        ->label('Nama Dosen')
                        ->default($status->user->name ?? '-')
                        ->weight(FontWeight::Bold)
                        ->size(TextSize::Large),

                    TextEntry::make('status_' . $status->id)
                        ->label('Status Konfirmasi')
                        ->default($status->status_konfirmasi ?? '-')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Hadir' => 'success',
                            'Tidak Hadir' => 'danger',
                            default => 'warning',
                        }),

                    TextEntry::make('alasan_' . $status->id)
                        ->label('Alasan Penolakan')
                        ->default($status->alasan_penolakan ?? '-'),
                ]);
        }

        return $schema->components([
            Section::make('Status Undangan')
                ->schema([
                    Grid::make(4)
                        ->schema($sections),
                ]),
        ]);

    }

    public function infoData(Schema $schema): Schema
    {
        $idMahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();
        $dataJudul = Judul::where('id_mahasiswa', $idMahasiswa->id)->first();

        return $schema
            ->record($dataJudul)
            ->components([
                // Section 1: Informasi Judul
                Section::make('Informasi Judul')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        TextEntry::make('judul')
                            ->label('Judul Penelitian')
                            ->icon('heroicon-m-document-text')
                            ->weight('medium')
                            ->size('lg')
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
                            ->color('purple')
                            ->placeholder('Belum ditentukan'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Section 2: Tim Pembimbing
                Section::make('Tim Pembimbing')
                    ->icon('heroicon-o-user-group')
                    ->description('Dosen pembimbing yang ditugaskan')
                    ->schema([
                        TextEntry::make('pembimbing_satu')
                            ->label('Pembimbing 1')
                            ->icon('heroicon-m-user-circle')
                            ->weight('medium')
                            ->default('Belum ditentukan')
                            ->color('success'),

                        TextEntry::make('pembimbing_dua')
                            ->label('Pembimbing 2')
                            ->icon('heroicon-m-user-circle')
                            ->weight('medium')
                            ->default('Belum ditentukan')
                            ->color('success'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Section 3: Tim Penguji
                Section::make('Tim Penguji')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('Dosen penguji yang ditugaskan')
                    ->schema([
                        TextEntry::make('penguji_satu')
                            ->label('Penguji 1')
                            ->icon('heroicon-m-academic-cap')
                            ->weight('medium')
                            ->default('Belum ditentukan')
                            ->color('warning'),

                        TextEntry::make('penguji_dua')
                            ->label('Penguji 2')
                            ->icon('heroicon-m-academic-cap')
                            ->weight('medium')
                            ->default('Belum ditentukan')
                            ->color('warning'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public function uploadForm(Schema $schema): Schema
    {
        return $schema->components([
           FileUpload::make('softcopy_file_path')
               ->label('Draft Proposal atau Skripsi')
               ->directory('uploaded-draft')
               ->disk('public')
               ->acceptedFileTypes(['application/pdf'])
               ->maxSize(10240) // 10MB
               ->moveFiles()
               ->helperText('Upload file PDF (maksimal 10MB)')
               ->columnSpanFull()
               ->required()
            ->statePath('softcopy'),

            Checkbox::make('kesiapan')
                ->label('Dengan ini, saya menyatakan kesiapan saya untuk menghadiri ujian.')
                ->accepted()
                ->required()
            ->statePath('kesiapandata')

        ]);

    }

    public function konfirmasi()
    {
        $idMahasiswa = Mahasiswa::where('id_user', auth()->user()->id)->first();
        $dataJudul = Judul::where('id_mahasiswa', $idMahasiswa->id)->first();
        $dataUndangan = Undangan::where('id_judul', $dataJudul->id)->first();
        $data = $this->uploadForm->getState();
//        dd($data);

        $dataUndangan->update([
            'softcopy_file_path' => $data['softcopy'],
            'status_ujian' => 'draft_uploaded'
        ]);

        Notification::make()
            ->title('Berhasil Upload Draft')
            ->success()
            ->send();

        $this->redirect(static::getUrl());
    }

}
