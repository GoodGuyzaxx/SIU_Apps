<?php

namespace App\Filament\Dosen\Resources\Undangans\Pages;

use App\Filament\Dosen\Resources\Undangans\UndanganResource;
use App\Models\StatusUndangan;
use App\Models\Undangan;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\matches;

class DetailUndangan extends Page
{
    protected static string $resource = UndanganResource::class;

    protected string $view = 'filament.dosen.resources.undangans.pages.detail-undangan';

    public ?object $idDosen = null;

    public ?object $statusUndangan = null;

    public ?object $undangan = null;


    public function mount():void
    {
        $this->idDosen = auth()->user();
        $this->statusUndangan = StatusUndangan::where('id_dosen', $this->idDosen->id)->first();
        $this->undangan = Undangan::find($this->statusUndangan->id_undangan);
    }


    public function infoUndangan(Schema $schema): Schema
    {
        return $schema
            ->record($this->statusUndangan->undangan)
            ->components([
                Section::make('Undangan '. $this->statusUndangan->undangan->judul->jenis)
                 ->schema([
                     Grid::make()
                     ->schema([
                         Section::make('Detail Undangan')
                         ->schema([
                             TextInput::make('nomor')
                             ->label('Nomor Surat')
                             ->disabled()
                             ->placeholder($this->statusUndangan->undangan->nomor),

                             TextInput::make('perihal')
                                 ->label('Perihal Undangan')
                                 ->disabled()
                                 ->placeholder($this->statusUndangan->undangan->perihal),

                         ]),
                         Section::make('Jadwal Ujian')
                         ->schema([
                             TextInput::make('tanggal_hari')
                             ->label('Tanggal')
                             ->disabled()
                             ->placeholder(Carbon::createFromFormat('Y-m-d', $this->statusUndangan->undangan->tanggal_hari)->format('d/m/Y')),

                             TextInput::make('waktu')
                             ->label('Waktu')
                             ->disabled()
                             ->placeholder(Carbon::parse($this->statusUndangan->undangan->waktu)->format('H:i')),

                             TextArea::make('tempat')
                             ->label('Tempat Dilaksanakan')
                             ->disabled()
                             ->placeholder($this->statusUndangan->undangan->tempat),

                         ])

                     ])
                 ])
            ]);
    }

    public function infoJudulAndMahasiswa(Schema $schema): Schema {
//        dd($this->statusUndangan->undangan->softcopy_file_path);
        return $schema->record($this->undangan)->components([
            Section::make('Detail Judul dan Data Mahasiswa/i')
                ->schema([
                    Grid::make(2)
                    ->schema([
                        TextEntry::make('judul.mahasiswa.nama')
                            ->label('Nama Mahasiswa/i')
                            ->disabled()
                            ->placeholder($this->statusUndangan->undangan->judul->mahasiswa->nama),

                        TextEntry::make('judul.mahasiswa.npm')
                            ->label('NPM (Nomor Pokok Mahasiswa)')
                            ->disabled()
                            ->placeholder($this->statusUndangan->undangan->judul->mahasiswa->npm),

                        TextEntry::make('judul.judul')
                            ->label('Judul')
                            ->columnSpanFull()
                            ->extraAttributes(['class' => 'text-lg'])
                            ->alignCenter(),

                        Fieldset::make('Draft Naskah')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Action::make('Tampilkan')
                                        ->url(
                                            function (){
                                                return asset('storage/'.$this->undangan->softcopy_file_path);
                                            }
                                        )->color('warning')
                                        ->icon('heroicon-o-eye')
                                        ->openUrlInNewTab(),

                                        Action::make('Download')
                                        ->color('success')
                                        ->icon('heroicon-o-arrow-down-tray')
                                        ->extraAttributes(['class' => 'ms-4'])
                                        ->action(function () {
                                            return Storage::disk('public')->download($this->undangan->softcopy_file_path);
                                        }),
                                    ])
                            ])
                    ])
                ])
        ]);
    }

    public function infoStatusUndangan(Schema $schema): Schema
    {
        // Ambil semua status undangan untuk undangan ini
        $dataStatus = StatusUndangan::with('user')
            ->where('id_undangan', $this->undangan->id)
            ->get();

        // Dosen yang sedang login
        $currentDosenId = auth()->user()->id ?? null;

        // Status untuk dosen yang login (Status Saya)
        $statusSaya = $dataStatus->firstWhere('id_dosen', $currentDosenId);

        $sections = [];

        /*
         * SECTION: STATUS SAYA
         * ------------------------------------------------------------------
         */
        if ($statusSaya) {
            $labelRole = match($statusSaya->role){
                'pembimbing_satu', 'pembimbing1' => 'Pembimbing 1',
                'pembimbing_dua', 'pembimbing2' => 'Pembimbing 2',
                'penguji_satu', 'penguji1'       => 'Penguji 1',
                'penguji_dua', 'penguji2'       => 'Penguji 2',
                default                       => '-',
            };
            $sections[] = Section::make('Status Saya')
                ->schema([
                    TextEntry::make('role_saya')
                        ->label('Sebagai')
                        ->default($labelRole ?? '-')
                        ->weight(FontWeight::Bold)
                        ->size(TextSize::Large),

                    TextEntry::make('status_saya')
                        ->label('Status Konfirmasi')
                        ->default($statusSaya->status_konfirmasi ?? '-')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Hadir' => 'success',
                            'Tidak Hadir' => 'danger',
                            default => 'warning',
                        }),

                    TextEntry::make('alasan_saya')
                        ->label('Alasan Penolakan')
                        ->default($statusSaya->alasan_penolakan ?? '-')
                        ->visible(fn () => $statusSaya->status_konfirmasi === 'Tidak Hadir'),
                ]);
        }

        /*
         * SECTION: PEMBIMBING & PENGUJI (DOSEN 2–4)
         * ------------------------------------------------------------------
         * Di-generate dari collection $dataStatus,
         * selain dosen yang login.
         */
        $dataLain = $dataStatus->filter(function ($item) use ($currentDosenId) {
            return $item->id_dosen !== $currentDosenId;
        });

        foreach ($dataLain as $status) {

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
                    Actions::make([
                        Action::make('konfirmasi')
                            ->label('Konfrimasi Kehadiran')
                            ->size(10)
                            ->color('success')
                            ->icon('heroicon-m-check')
                            ->visible(fn () => $statusSaya->id_dosen === $currentDosenId)
                            ->requiresConfirmation()
                            ->modalDescription('Apakah Anda Bersedia Hadir?')
                            ->modalCancelActionLabel('Batal')
                            ->modalSubmitActionLabel('Ya,Saya Bersedia')
                            ->visible(function () {
                                return $this->statusUndangan->status_konfirmasi !== 'Hadir' && $this->statusUndangan->status_konfirmasi !== 'Tidak Hadir';
                            })
                            ->action(function () {
                                $this->statusUndangan->status_konfirmasi = 'Hadir';
                                $this->statusUndangan->confirmed_at =Carbon::now();
                                $this->statusUndangan->save();
                                Notification::make()
                                    ->title('Berhasil Konfirmasi Kehadiran')
                                    ->success()
                                    ->send();
                                $this->redirect(static::getUrl(['record' => $this->undangan->id]));
                            }),

                        Action::make('tolak')
                            ->label('Tolak Undangan')
                            ->icon('heroicon-m-x-mark')
                            ->color('danger')
                            ->visible(function () use ($statusSaya, $currentDosenId) {
                                return $statusSaya->id_dosen === $currentDosenId && empty($statusSaya->alasan_penolakan) && $statusSaya->status_konfirmasi !== 'Hadir' ;
                            })
                            ->schema([
                                Textarea::make('alasan')
                                    ->label('Alasan Tidak Dapat Hadir')
                                    ->required()
                                    ->rows(3)
                            ])
                            ->action(function (array $data): void {
                                $this->statusUndangan->status_konfirmasi = 'Tidak Hadir';
                                $this->statusUndangan->alasan_penolakan = $data['alasan'];
                                $this->statusUndangan->save();
                                Notification::make()
                                    ->title('Berhasil Menolak Undangan')
                                    ->success()
                                    ->send();
                            })
                    ]),
                ]),
        ]);


    }



}
