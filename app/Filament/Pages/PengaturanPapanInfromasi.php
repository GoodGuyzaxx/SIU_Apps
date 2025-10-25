<?php

namespace App\Filament\Pages;

use App\Models\Judul;
use App\Models\Undangan;
use App\Models\UsulanJudul;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\PapanInformasi;
use UnitEnum;

class PengaturanPapanInfromasi extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Papan Informasi Digital';

    protected string $view = 'filament.pages.papan-informasi';

    protected static string | UnitEnum | null $navigationGroup = "Display & TV";
    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    protected function getHeaderActions(): array
    {
        return [
          Action::make('papan-informasi')
            ->label('Papan Informasi')
            ->url(fn () => url(route('info')))
            ->openUrlInNewTab()
        ];
    }

//    SCHEME
\
    public function informasiForm(Schema $schema): Schema{
        return $schema->components([
           Section::make('Papan Infromasi Digital')
           ->schema([
               TextInput::make('yt_url')
                   ->label('Masukan URL Youtube')
                   ->suffixIcon('heroicon-o-globe-alt')
                   ->url(),
           ]),
            Section::make('Informasi Jadwal Proposal')
                ->description('Masukan rentang Tanggal jadwal proposal yang akan ditampilkan')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            DatePicker::make('tanggal_awal_proposal')
                                ->label('Rentang tanggal awal proposal'),
                            DatePicker::make('tanggal_akhir_proposal')
                                ->label('Rentang tanggal akhir proposal'),
                        ])
                ]),
            Section::make('Informasi Jadwal Skripsi')
                ->description('Masukan rentan Tanggal jadwal Skripsi yang akan ditampilkan')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            DatePicker::make('tanggal_awal_skripsi')
                                ->label('Rentang tanggal awal skripsi'),
                            DatePicker::make('tanggal_akhir_skripsi')
                                ->label('Rentang tanggal akhir skripsi'),
                        ])
                ]),
            Section::make('Informasi Pengajuan Judul')
                ->description('Masukan rentan Tanggal Pengajuan Judual yang akan ditampilkan')
                ->schema([
                    Grid::make(1)
                        ->schema([
                            DatePicker::make('tanggal_pengajuan')
                                ->label('Rentang dalam Bulan')
                                ->format('m')
                                ->extraInputAttributes(['type' => 'month']),
                        ])
                ]),
        ])->statePath('data');
    }

//     Function Save Data....
    public function saveData()
    {
        $dataForm = $this->informasiForm->getState();
//        dd($dataForm);

        $dataProposal = Undangan::with( 'judul')
            ->whereHas('judul', function ($query) {
                $query->where('jenis', 'proposal');
            })
            ->whereBetween('tanggal_hari', [
                $dataForm['tanggal_awal_proposal'],
                $dataForm['tanggal_akhir_proposal'],
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'nama'  => $item->judul->mahasiswa->nama ?? '-',
                    'npm'   => $item->judul->mahasiswa->npm ?? '-',
                    'judul' => $item->judul->judul ?? '-',
                    'tanggal_hari' => $item->tanggal_hari ?? '-',
                    'waktu' => $item->waktu ?? '-'
                ];
            });

        $dataUjianAkhir = Undangan::with( 'judul')
            ->whereHas('judul', function ($query) {
                $query->where('jenis', 'skripsi');
            })
            ->whereBetween('tanggal_hari', [
                $dataForm['tanggal_awal_skripsi'],
                $dataForm['tanggal_akhir_skripsi'],
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'nama'  => $item->judul->mahasiswa->nama ?? '-',
                    'npm'   => $item->judul->mahasiswa->npm ?? '-',
                    'judul' => $item->judul->judul ?? '-',
                    'tanggal_hari' => $item->tanggal_hari ?? '-',
                    'waktu' => $item->waktu ?? '-'
                ];
            });


        $dataUsulan = UsulanJudul::with('mahasiswa')
            ->whereMonth('created_at', $dataForm['tanggal_pengajuan'])
            ->get()
            ->map(function ($usulan) {
                return [
                    'nama' => $usulan->mahasiswa->nama,
                    'npm' => $usulan->mahasiswa->npm,
                    'status' => $usulan->status,
                ];
            });


//        dd($dataUsulan);

        $papanInfromasi = PapanInformasi::where('id', 1)->first();
        $papanInfromasi->update([
            'yt_url' => $dataForm['yt_url'],
            'jadwal_proposal' => $dataProposal,
            'jadwal_skripsi' => $dataUjianAkhir,
            'pengajuan_judul' => $dataUsulan
        ]);

        Notification::make()
            ->title("Data Berhasil Disimpan")
            ->success()
            ->send();

    }

//      Open Infromasi
}
