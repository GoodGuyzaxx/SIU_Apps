<?php

namespace App\Filament\Dosen\Resources\Undangans\Pages;

use App\Filament\Dosen\Resources\Undangans\UndanganResource;
use App\Models\AccKesiapanUjian;
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
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;


class DetailUndangan extends Page
{
    use InteractsWithRecord;

    protected static string $resource = UndanganResource::class;

    protected string $view = 'filament.dosen.resources.undangans.pages.detail-undangan';

    public ?object $idDosen      = null;
    public ?object $statusUndangan = null;
    public ?object $undangan      = null;


    protected function getHeaderActions(): array
    {
        return [
            Action::make('Preview')
                ->label('Lihat Undangan')
                ->color('success')
                ->icon('heroicon-o-eye')
                ->url(route('undangan.pdf', $this->undangan->id)),
        ];
    }

    public function mount(int | string $record): void
    {
        $this->record        = $this->resolveRecord($record);
        $this->idDosen       = auth()->user();
        $this->statusUndangan = AccKesiapanUjian::where('id_dosen', $this->idDosen->id)->get();
        $this->undangan      = $this->record;
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Schema: Info Undangan
     └─────────────────────────────────────────────────────────────────────*/
    public function infoUndangan(Schema $schema): Schema
    {
        return $schema
            ->record($this->undangan)
            ->components([
                Section::make('Undangan ' . ($this->undangan->judul->jenis ?? ''))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Section::make('Detail Undangan')
                                    ->schema([
                                        TextInput::make('nomor')
                                            ->label('Nomor Surat')
                                            ->disabled()
                                            ->placeholder($this->undangan->nomor),

                                        TextInput::make('perihal')
                                            ->label('Perihal Undangan')
                                            ->disabled()
                                            ->placeholder($this->undangan->perihal),
                                    ]),

                                Section::make('Jadwal Ujian')
                                    ->schema([
                                        TextInput::make('tanggal_hari')
                                            ->label('Tanggal')
                                            ->disabled()
                                            ->placeholder(
                                                Carbon::createFromFormat('Y-m-d', $this->undangan->tanggal_hari)
                                                    ->translatedFormat('l, d F Y')
                                            ),

                                        TextInput::make('waktu')
                                            ->label('Waktu')
                                            ->disabled()
                                            ->placeholder(Carbon::parse($this->undangan->waktu)->format('H:i') . ' WIB'),

                                        TextArea::make('tempat')
                                            ->label('Tempat Dilaksanakan')
                                            ->disabled()
                                            ->placeholder($this->undangan->tempat),
                                    ]),
                            ]),
                    ]),
            ]);
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Schema: Info Judul & Mahasiswa
     └─────────────────────────────────────────────────────────────────────*/
    public function infoJudulAndMahasiswa(Schema $schema): Schema
    {
        return $schema->record($this->record)->components([
            Section::make('Detail Judul dan Data Mahasiswa/i')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('judul.mahasiswa.nama')
                                ->label('Nama Mahasiswa/i')
                                ->disabled()
                                ->placeholder($this->undangan->judul->mahasiswa->nama ?? '-'),

                            TextEntry::make('judul.mahasiswa.npm')
                                ->label('NPM (Nomor Pokok Mahasiswa)')
                                ->disabled()
                                ->placeholder($this->undangan->judul->mahasiswa->npm ?? '-'),

                            TextEntry::make('judul.judul')
                                ->label('Judul')
                                ->columnSpanFull()
                                ->weight(FontWeight::SemiBold)
                                ->alignCenter(),

                            Fieldset::make('Draft Naskah')
                                ->columnSpanFull()
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            Action::make('Tampilkan')
                                                ->url(fn () => asset('storage/' . $this->undangan->softcopy_file_path))
                                                ->color('warning')
                                                ->icon('heroicon-o-eye')
                                                ->openUrlInNewTab(),

                                            Action::make('Download')
                                                ->color('success')
                                                ->icon('heroicon-o-arrow-down-tray')
                                                ->action(function () {
                                                    return Storage::disk('public')->download(
                                                        $this->undangan->softcopy_file_path
                                                    );
                                                }),
                                        ]),
                                ]),
                        ]),
                ]),
        ]);
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Schema: Status Undangan
     |  FIX: gunakan $status->dosen->nama (bukan $status->user->name)
     |       dan with('dosen.user') agar eager-loaded dengan benar
     └─────────────────────────────────────────────────────────────────────*/
    public function infoStatusUndangan(Schema $schema): Schema
    {
        // Eager-load relasi dosen (dan user-nya untuk fallback nama)
        $dataStatus = AccKesiapanUjian::with('dosen.user')
            ->where('id_undangan', $this->undangan->id)
            ->get();

        $currentDosenId = auth()->user()?->dosen?->id;

        $statusSaya = $dataStatus->firstWhere('id_dosen', $currentDosenId);

        $sections = [];

        // ── Kartu "Status Saya" ─────────────────────────────────────────────
        if ($statusSaya) {
            $labelRole = $this->resolveRoleLabel($statusSaya->role);

            $sections[] = Section::make('Status Saya')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    TextEntry::make('role_saya')
                        ->label('Peran Saya')
                        ->default($labelRole)
                        ->weight(FontWeight::Bold)
                        ->size(TextSize::Large),

                    TextEntry::make('status_saya')
                        ->label('Status Konfirmasi')
                        ->default($statusSaya->status ?? 'pending')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'disetujui' => 'success',
                            'ditolak'   => 'danger',
                            default     => 'warning',
                        }),

                    TextEntry::make('alasan_saya')
                        ->label('Alasan Penolakan')
                        ->default($statusSaya->alasan_penolakan ?? '-')
                        ->visible(fn () => $statusSaya->status === 'ditolak'),
                ]);
        }

        // ── Kartu dosen lain ────────────────────────────────────────────────
        $dataLain = $dataStatus->filter(fn ($item) => $item->id_dosen !== $currentDosenId);

        foreach ($dataLain as $status) {
            $label = $this->resolveRoleLabel($status->role);

            // Ambil nama: prioritaskan Dosen.nama, fallback ke User.name
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

        // ── Cek apakah aksi konfirmasi/tolak masih bisa ditampilkan ──────────
        $isPending    = $statusSaya?->status === 'pending';
        $isNotGagal   = $this->undangan->status_ujian !== 'gagal_menjadwalkan_ujian';
        $bisaTolak    = $statusSaya !== null
                        && empty($statusSaya->alasan_penolakan)
                        && $statusSaya->status !== 'disetujui'
                        && $statusSaya->id_dosen === $currentDosenId;

        return $schema->components([
            Section::make('Status Undangan')
                ->icon('heroicon-o-clipboard-document-list')
                ->schema([
                    Grid::make(2)
                        ->schema($sections),

                    Actions::make([
                        // ── Konfirmasi Kehadiran ─────────────────────────────
                        Action::make('konfirmasi')
                            ->label('Konfirmasi Kehadiran')
                            ->color('success')
                            ->icon('heroicon-m-check-circle')
                            ->requiresConfirmation()
                            ->modalHeading('Konfirmasi Kehadiran')
                            ->modalDescription('Apakah Anda bersedia hadir dalam sidang ini?')
                            ->modalCancelActionLabel('Batal')
                            ->modalSubmitActionLabel('Ya, Saya Bersedia')
                            ->visible(fn () => $isPending && $isNotGagal)
                            ->action(function () use ($currentDosenId) {
                                $acc = $this->undangan->accKesiapanUjian
                                    ->where('id_dosen', $currentDosenId)
                                    ->first();
                                if ($acc) {
                                    $acc->status       = 'disetujui';
                                    $acc->responded_at = Carbon::now();
                                    $acc->save();
                                }
                                Notification::make()
                                    ->title('Kehadiran dikonfirmasi!')
                                    ->success()
                                    ->send();
                                $this->redirect(static::getUrl(['record' => $this->undangan->id]));
                            }),

                        // ── Tolak Undangan ───────────────────────────────────
                        Action::make('tolak')
                            ->label('Tolak Undangan')
                            ->icon('heroicon-m-x-circle')
                            ->color('danger')
                            ->visible(fn () => $bisaTolak && $isNotGagal)
                            ->schema([
                                Textarea::make('alasan')
                                    ->label('Alasan Tidak Dapat Hadir')
                                    ->placeholder('Jelaskan alasan penolakan Anda…')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->action(function (array $data) use ($currentDosenId): void {
                                $acc = $this->undangan->accKesiapanUjian
                                    ->where('id_dosen', $currentDosenId)
                                    ->first();
                                if ($acc) {
                                    $acc->status           = 'ditolak';
                                    $acc->alasan_penolakan = $data['alasan'];
                                    $acc->responded_at     = Carbon::now();
                                    $acc->save();
                                }
                                Notification::make()
                                    ->title('Undangan ditolak.')
                                    ->warning()
                                    ->send();
                                $this->redirect(static::getUrl(['record' => $this->undangan->id]));
                            }),
                    ]),
                ]),
        ]);
    }


    /* ──────────────────────────────────────────────────────────────────────
     |  Helper: terjemahkan nilai kolom `role` ke label yang rapi
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
