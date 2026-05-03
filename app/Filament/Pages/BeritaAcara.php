<?php

namespace App\Filament\Pages;

use App\Models\Dosen;
use App\Models\Judul;
use App\Models\Undangan;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use UnitEnum;

class BeritaAcara extends Page
{
    protected string $view = 'filament.pages.berita-acara';


    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document';

    protected ?string $heading = 'Berita Acara';

    public ?string $id_judul = null;

    public ?string $waktu = null;

    public ?string $jenis = null;
    public ?string $pembimbing_1 = null;
    public ?string $pembimbing_2 = null;
    public ?string $penguji_1 = null;
    public ?string $penguji_2 = null;
    public ?string $penguji_3 = null;

    protected static ?int $navigationSort = 6;

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    public static function canAccess(): bool
    {
        if (auth()->user()->role === 'admin'){
            return true;
        } elseif(auth()->user()->role === 'akademik'){
            return true;
        }
        return false;
    }


    static public function cetakForm(Schema $scheme): Schema {
        return  $scheme
            ->components([
                Section::make('Cetak Berita Acara')
                ->schema([
                    Select::make('jenis')
                        ->label('Jenis Berita Acara')
                        ->native(false)
                        ->options([
                            'proposal' => 'Proposal',
                            'hasil' => 'Seminar Hasil',
                        ])
                        ->required()
                    ->statePath('jenis'),
                    Select::make('id_judul')
                        ->label('Mahasiswa')
                        ->options(Undangan::with('judul.mahasiswa')->get()->mapWithKeys(function ($undangan) {
                            if ($undangan->judul && $undangan->judul->mahasiswa) {
                                return [$undangan->id => $undangan->judul->judul . ' - ' . $undangan->judul->mahasiswa->nama . ' - ' . $undangan->judul->mahasiswa->npm];
                            }
                            return [];
                        }))
                        ->required()
                        ->loadingMessage('Sedang Mencari')
                        ->noSearchResultsMessage('Data Tidak Ditemukan')
                        ->searchable()
                        ->reactive()
//                        ->afterStateUpdated(function ($state, callable $set) {
//                            if ($state) {
//                                $undangan = Undangan::with('judul')->find($state);
//                                if ($undangan && $undangan->judul) {
//                                    $judul = $undangan->judul;
//                                    $set('pembimbing_1', $judul->pembimbing_satu);
//                                    $set('pembimbing_2', $judul->pembimbing_dua);
//                                    $set('penguji_1', $judul->penguji_satu);
//                                    $set('penguji_2', $judul->penguji_dua);
//                                }
//                            } else {
//                                $set('pembimbing_1', null);
//                                $set('pembimbing_2', null);
//                                $set('penguji_1', null);
//                                $set('penguji_2', null);
//                            }
//                        })
                        ->statePath('id_judul'),
//                    Section::make('List Pembimbing dan Penguji')
//                    ->schema([
//                        Select::make('pembimbing_1')
//                            ->label('Pembimbing 1')
//                            ->options(Dosen::all()->pluck('nama', 'id'))
//                            ->searchable()
//                            ->statePath('pembimbing_1'),
//                        Select::make('pembimbing_2')
//                            ->label('Pembimbing 2')
//                            ->options(Dosen::all()->pluck('nama', 'id'))
//                            ->searchable()
//                            ->statePath('pembimbing_2'),
//                        Select::make('penguji_1')
//                            ->label('Penguji 1')
//                            ->options(Dosen::all()->pluck('nama', 'id'))
//                            ->searchable()
//                            ->statePath('penguji_1'),
//                        Select::make('penguji_2')
//                            ->label('Penguji 2')
//                            ->options(Dosen::all()->pluck('nama', 'id'))
//                            ->searchable()
//                            ->statePath('penguji_2'),
//                    ])
                ]),
            ]);
    }

    public function cetak(): void {
        $data = $this->cetakForm->getState();
        // dd($data);
        $url = route('beritaPDF', [
            'id' => $data['id_judul'],
            'jenis' => $data['jenis'],
            'pembimbing_1' => $data['pembimbing_1'] ?? null,
            'pembimbing_2' => $data['pembimbing_2'] ?? null,
            'penguji_1' => $data['penguji_1'] ?? null,
            'penguji_2' => $data['penguji_2'] ?? null,
        ]);

        $this->js("window.open('{$url}', '_blank')");
    }
}
