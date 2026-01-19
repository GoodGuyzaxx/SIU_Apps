<?php

namespace App\Filament\Pages;

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
                        ->options(Undangan::query()->get()->mapWithKeys(function ($undangan) {
                            return [$undangan->id => $undangan->judul->judul . ' - ' . $undangan->judul->mahasiswa->nama . ' - ' . $undangan->judul->mahasiswa->npm];
                        }))
                        ->required()
                        ->loadingMessage('Sedang Mencari')
                        ->noSearchResultsMessage('Data Tidak Ditemukan')
                        ->searchable()
                        ->statePath('id_judul'),
                ])
            ]);
    }

    public function cetak(): void {
        $data = $this->cetakForm->getState();
       $this->redirect(route('beritaPDF',[$data['id_judul'],$data['jenis']]));
    }
}
