<?php

namespace App\Filament\Resources\Pengajuans\Pages;

use App\Filament\Resources\Juduls\Pages\ListJuduls;
use App\Filament\Resources\Pengajuans\PengajuanResource;
use App\Models\Dosen;
use App\Models\Judul;
use App\Models\SuratKeputusan;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class DetailPengajuan extends Page
{
    use InteractsWithRecord;

    protected static string $resource = PengajuanResource::class;


    public ?array $data = [];

    public string $judul = 'default';

    public ?string $idMahasiswa = null;

    protected ?string $heading = "Detail Pengajuan Judul";

    protected string $view = 'filament.resources.pengajuans.pages.detail-pengajuyan';



    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->rejectForm->fill();
        $this->approveForm->fill();
        $this->idMahasiswa = $this->record->id_mahasiswa;
    }

    public function editPengajuan($id)
    {
        return redirect()->route('filament.admin.resources.pengajuan.edit', $id);
    }

    static public function approveForm(Schema $schema): Schema
    {
        $dataDosen = Dosen::all();

        return $schema
            ->components([
                Select::make('pembimbing_satu')
                    ->label('Pembimbing Pertama')
                    ->required()
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),

                Select::make('pembimbing_dua')
                    ->label('Pembimbing Kedua')
                    ->required()
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),

                Select::make('penguji_satu')
                    ->label('Penguji Pertama')
                    ->required()
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),


                Select::make('penguji_dua')
                    ->label('Pembimbing Kedua')
                    ->required()
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable()

            ])
            ->statePath('data');
    }

    public function approve(): void
    {
        $data = $this->approveForm->getState();
//        dd($this->record->mahasiswa->id);
//        dd($this->record->minat_kekuhusan);
        $this->record->update([
            'status'  => 'Disetujui',
            'catatan' => null,
        ]);

        $dataJudul = Judul::create([
           'id_mahasiswa' => $this->record->mahasiswa->id,
            'minat' => $this->record->minat_kekuhusan,
            'judul' => $this->judul,
            'jenis' => 'proposal',
            'pembimbing_satu' => $data['pembimbing_satu'],
            'pembimbing_dua' => $data['pembimbing_dua'],
            'penguji_satu' => $data['penguji_satu'],
            'penguji_dua' => $data['penguji_dua'],
        ]);

        SuratKeputusan::create([
            'id_judul' => $dataJudul->id,
            'nomor_sk_penguji' => "HARAP ISI NOMOR",
            'nomor_sk_pembimbing' => "HARAP ISI NOMOR"
        ]);

        Notification::make()
            ->title('Pengajuan disetujui')
            ->success()
            ->send();

        $this->redirect(ListJuduls::getUrl());
    }


    static public function rejectForm(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('catatan')
                ->label('Catatan Penolakan')
                ->placeholder('Tuliskan alasan penolakan di sini...')
                ->rows(5)
                ->required()
                ->columnSpanFull()
                ->helperText('Berikan alasan singkat mengapa pengajuan ini ditolak.')
                ->extraAttributes([
                    'class' => 'resize-none rounded-md border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50'
                ])
            ,
        ])
            ->statePath('data');
    }

    public function reject(): void
    {
        $data = $this->rejectForm->getState();

        $this->record->update([
            'status'  => 'Ditolak',
            'catatan' => $data['catatan'],
        ]);


        Notification::make()
            ->title('Pengajuan ditolak')
            ->warning()
            ->send();

        $this->dispatch('refresh');
    }



}
