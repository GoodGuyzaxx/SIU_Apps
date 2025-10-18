<?php

namespace App\Filament\Pages;

use App\Models\Judul;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BeritaAcara extends Page
{
    protected string $view = 'filament.pages.berita-acara';


    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document';

    protected ?string $heading = 'Berita Acara';

    public ?string $id_judul = null;

    public ?string $jenis = null;
    protected static ?int $navigationSort = 6;


    static public function cetakForm(Schema $scheme): Schema {
        return  $scheme
            ->components([
                Section::make('Cetak Berita Acara')
                ->schema([
                    Select::make('jenis')
                        ->label('Jenis Berita Acara')
                        ->options([
                            'proposal' => 'Proposal',
                            'hasil' => 'Seminar Hasil',
                        ])
                        ->required()
                    ->statePath('jenis'),
                    Select::make('id_judul')
                        ->label('Mahasiswa')
                        ->options(Judul::query()->with('mahasiswa')->get()->mapWithKeys(function ($judul) {
                            $mahasiswaNama = $judul->mahasiswa ? $judul->mahasiswa->nama : 'Tidak ada mahasiswa';
                            return [$judul->id => $mahasiswaNama . ' - ' . $judul->mahasiswa->npm . ' - ' . $judul->judul];
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
