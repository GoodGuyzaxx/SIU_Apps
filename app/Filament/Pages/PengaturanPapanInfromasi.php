<?php

namespace App\Filament\Pages;

use App\Models\PapanInformasi;
use App\Models\Undangan;
use App\Models\UsulanJudul;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class PengaturanPapanInfromasi extends Page
{
    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-globe-alt";
    protected static ?string $navigationLabel = "Papan Informasi Digital";

    protected string $view = "filament.pages.papan-informasi";

    protected static string|UnitEnum|null $navigationGroup = "Display & TV";
    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    public static function canAccess(): bool
    {
        if (auth()->user()->role === 'admin'){
            return true;
        } elseif(auth()->user()->role === 'akademik'){
            return true;
        }
        return false;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make("papan-informasi")
                ->label("Papan Informasi")
                ->url(fn() => url(route("info")))
                ->openUrlInNewTab(),
        ];
    }

    //    SCHEME
    public function informasiForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Papan Infromasi Digital")->schema([
                    TextInput::make("yt_url")
                        ->label("Masukan URL Youtube")
                        ->suffixIcon("heroicon-o-globe-alt")
                        ->url(),
                    Textarea::make('running_text')
                        ->label("Running Text")
                        ->autosize(true),
                ]),
                Section::make("Informasi Jadwal Proposal")
                    ->description(
                        "Masukan rentang Tanggal jadwal proposal yang akan ditampilkan",
                    )
                    ->schema([
                        Grid::make(2)->schema([
                            DatePicker::make("tanggal_awal_proposal")->label(
                                "Rentang tanggal awal proposal",
                            ),
                            DatePicker::make("tanggal_akhir_proposal")->label(
                                "Rentang tanggal akhir proposal",
                            ),
                        ]),
                    ]),
                Section::make("Informasi Jadwal Skripsi")
                    ->description(
                        "Masukan rentan Tanggal jadwal Skripsi yang akan ditampilkan",
                    )
                    ->schema([
                        Grid::make(2)->schema([
                            DatePicker::make("tanggal_awal_skripsi")->label(
                                "Rentang tanggal awal skripsi",
                            ),
                            DatePicker::make("tanggal_akhir_skripsi")->label(
                                "Rentang tanggal akhir skripsi",
                            ),
                        ]),
                    ]),
                Section::make("Informasi Pengajuan Judul")
                    ->description(
                        "Masukan rentan Tanggal Pengajuan Judual yang akan ditampilkan",
                    )
                    ->schema([
                        Grid::make(1)->schema([
                            DatePicker::make("tanggal_pengajuan")
                                ->label("Rentang dalam Bulan")
                                ->format("m")
                                ->extraInputAttributes(["type" => "month"]),
                        ]),
                    ]),
            ])
            ->statePath("data");
    }

    public function saveData()
    {
        $dataForm = $this->informasiForm->getState();

        DB::transaction(function () use ($dataForm) {
            $papanInformasi = PapanInformasi::findOrFail(1);

            $payload = [];

            $payload['yt_url'] = $dataForm['yt_url'] ?? $papanInformasi->yt_url;
            $payload['running_text'] = $dataForm['running_text'] ?? $papanInformasi->running_text;

            $proposalRaw = Undangan::with('judul.mahasiswa')
                ->whereHas('judul', fn ($q) => $q->where('jenis', 'proposal'))
                ->whereBetween('tanggal_hari', [
                    $dataForm['tanggal_awal_proposal'],
                    $dataForm['tanggal_akhir_proposal'],
                ])
                ->get();

            if ($proposalRaw->isNotEmpty()) {
                $payload['jadwal_proposal'] = $proposalRaw->map(function ($item) {
                    return [
                        'nama'         => $item->judul->mahasiswa->nama  ?? '-',
                        'npm'          => $item->judul->mahasiswa->npm   ?? '-',
                        'judul'        => $item->judul->judul            ?? '-',
                        'tanggal_hari' => $item->tanggal_hari            ?? '-',
                        'waktu'        => $item->waktu                   ?? '-',
                    ];
                })->values();
            }
            $skripsiRaw = Undangan::with('judul.mahasiswa')
                ->whereHas('judul', fn ($q) => $q->where('jenis', 'skripsi'))
                ->whereBetween('tanggal_hari', [
                    $dataForm['tanggal_awal_skripsi'],
                    $dataForm['tanggal_akhir_skripsi'],
                ])
                ->get();

            if ($skripsiRaw->isNotEmpty()) {
                $payload['jadwal_skripsi'] = $skripsiRaw->map(function ($item) {
                    return [
                        'nama'         => $item->judul->mahasiswa->nama  ?? '-',
                        'npm'          => $item->judul->mahasiswa->npm   ?? '-',
                        'judul'        => $item->judul->judul            ?? '-',
                        'tanggal_hari' => $item->tanggal_hari            ?? '-',
                        'waktu'        => $item->waktu                   ?? '-',
                    ];
                })->values();
            }


            $usulanRaw = UsulanJudul::with('mahasiswa')
                ->whereMonth('created_at', $dataForm['tanggal_pengajuan'])
                ->get();

            if ($usulanRaw->isNotEmpty()) {
                $payload['pengajuan_judul'] = $usulanRaw->map(function ($u) {
                    return [
                        'nama'   => $u->mahasiswa->nama ?? '-',
                        'npm'    => $u->mahasiswa->npm  ?? '-',
                        'status' => $u->status          ?? '-',
                    ];
                })->values();
            }

            if (! empty($payload)) {
                $papanInformasi->update($payload);
                Notification::make()
                    ->title('Data Berhasil Disimpan')
                    ->body('Field yang diperbarui: ' . implode(', ', array_keys($payload)))
                    ->success()
                    ->send();
            } else {

                Notification::make()
                    ->title('Tidak Ada Perubahan')
                    ->body('Tidak ada data baru ditemukan pada rentang yang dipilih. Data lama tetap dipertahankan.')
                    ->warning()
                    ->send();
            }
        });
    }

    //     Function Save Data....
//    public function saveData()
//    {
//        $dataForm = $this->informasiForm->getState();
////                dd($dataForm);
//        $dataPapanInformasi = PapanInformasi::find('1');
//
//
//        $dataProposal = Undangan::with("judul")
//            ->whereHas("judul", function ($query) {
//                $query->where("jenis", "proposal");
//            })
//            ->whereBetween("tanggal_hari", [
//                $dataForm["tanggal_awal_proposal"],
//                $dataForm["tanggal_akhir_proposal"],
//            ])
//            ->get()
//            ->map(function ($item) {
//                return [
//                    "nama" => $item->judul->mahasiswa->nama ?? "-",
//                    "npm" => $item->judul->mahasiswa->npm ?? "-",
//                    "judul" => $item->judul->judul ?? "-",
//                    "tanggal_hari" => $item->tanggal_hari ?? "-",
//                    "waktu" => $item->waktu ?? "-",
//                ];
//            });
//
//
//        $dataUjianAkhir = Undangan::with("judul")
//            ->whereHas("judul", function ($query) {
//                $query->where("jenis", "skripsi");
//            })
//            ->whereBetween("tanggal_hari", [
//                $dataForm["tanggal_awal_skripsi"],
//                $dataForm["tanggal_akhir_skripsi"],
//            ])
//            ->get()
//            ->map(function ($item) {
//                return [
//                    "nama" => $item->judul->mahasiswa->nama ?? "-",
//                    "npm" => $item->judul->mahasiswa->npm ?? "-",
//                    "judul" => $item->judul->judul ?? "-",
//                    "tanggal_hari" => $item->tanggal_hari ?? "-",
//                    "waktu" => $item->waktu ?? "-",
//                ];
//            });
//
//        $dataUsulan = UsulanJudul::with("mahasiswa")
//            ->whereMonth("created_at", $dataForm["tanggal_pengajuan"])
//            ->get()
//            ->map(function ($usulan) {
//                return [
//                    "nama" => $usulan->mahasiswa->nama,
//                    "npm" => $usulan->mahasiswa->npm,
//                    "status" => $usulan->status,
//                ];
//            });
//
////                dd($dataProposal);
//
//        $papanInfromasi = PapanInformasi::where("id", 1)->first();
//        $papanInfromasi->update([
//            "yt_url" => $dataForm["yt_url"],
//            'running_text' => $dataForm['running_text'],
//            "jadwal_proposal" => $dataProposal,
//            "jadwal_skripsi" => $dataUjianAkhir,
//            "pengajuan_judul" => $dataUsulan,
//        ]);
//
//        Notification::make()
//            ->title("Data Berhasil Disimpan")
//            ->success()
//            ->send();
//    }

    //      Open Infromasi
}
