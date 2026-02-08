<?php

namespace App\Filament\User\Pages\Profile\Pages;

use App\Models\Mahasiswa;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm extends Page implements  HasForms
{

    use InteractsWithForms;

    protected string $view = 'filament.user.pages.profile.pages.user-form';


    public ?array $data = [];

    protected ?string $heading = "Masukan Data";



//    public function getDefaultActionSuccessRedirectUrl(Action $action): ?string
//    {
//        return $this->getResource()::getUrl('index');
//    }

    protected static bool $shouldRegisterNavigation = false;

    public function mount(){
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
//        dd(auth()->user()->id);
        return $schema
            ->components([
                Hidden::make('id_user')
                    ->default(auth()->user()->id),
                Section::make()
                    ->schema([
                        // Grid untuk layout rapi
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama')
                                    ->label('Nama Lengkap')
                                    ->placeholder('Ahmad Budiman')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-m-user')
                                    ->columnSpan(2),

                                TextInput::make('npm')
                                    ->label('NPM')
                                    ->placeholder('2023010001')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->numeric()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-m-identification')
                                    ->helperText('Nomor Pokok Mahasiswa')
                                    ->columnSpan(1),

                                TextInput::make('nomor_hp')
                                    ->label('Nomor HP')
                                    ->placeholder('81234567890')
                                    ->required()
                                    ->tel()
                                    ->maxLength(15)
                                    ->prefix('+62')
                                    ->prefixIcon('heroicon-m-phone')
                                    ->helperText('Nomor HP Mahasiswa atau yang bisa dihubungi')
                                    ->columnSpan(1),

                                Select::make('jenjang')
                                    ->label('Jenjang')
                                    ->placeholder('Pilih Jenjang')
                                    ->native(false)
                                    ->required()
                                    ->prefixIcon('heroicon-o-academic-cap')
                                    ->options([
                                        'sarjana' => 'Sarjana / S1',
                                        'magister' => 'Magister / S2',
                                    ])
                                    ->live(),

                                Select::make('kelas')
                                    ->label('Kelas')
                                    ->placeholder('Pilih Kelas')
                                    ->required()
                                    ->native(false)
                                    ->prefixIcon('heroicon-o-clock')
                                    ->options([
                                        'pagi' => 'Kelas Reguler',
                                        'sore' => 'Kelas Ekstensi',
                                    ])
                                    ->visible(fn ($get) => $get('jenjang') === 'sarjana'),

                                Select::make('program_studi')
                                    ->label('Program Studi')
                                    ->placeholder('Pilih Program Studi')
                                    ->native(false)
                                    ->columnSpan(2)
                                    ->required()
                                    ->prefixIcon('heroicon-o-academic-cap')
                                    ->options(
                                        function ($get) {
                                            if ($get('jenjang') == 'magister') {
                                                return [
                                                    'Magister Hukum' => 'Magister Hukum',
                                                    'Kenotariatan' => 'Kenotariatan',
                                                ];
                                            }
                                            return [
                                              'Ilmu Hukum' => 'Ilmu Hukum',
                                            ];
                                        }
                                    ),

                                TextInput::make('angkatan')
                                    ->label('Angkatan')
                                    ->placeholder('Contoh 2021')
                                    ->columnSpan(2)
                                    ->prefixIcon('heroicon-o-academic-cap')
                                    ->required()
                                    ->type('number'),


                                Select::make('agama')
                                    ->label('Agama')
                                    ->placeholder('Pilih agama')
                                    ->required()
                                    ->options([
                                        'Islam' => 'Islam',
                                        'Kristen' => 'Kristen',
                                        'Katolik' => 'Katolik',
                                        'Hindu' => 'Hindu',
                                        'Buddha' => 'Buddha',
                                        'Konghucu' => 'Konghucu',
                                    ])
                                    ->native(false)
                                    ->searchable()
                                    ->prefixIcon('heroicon-m-sparkles')
                                    ->columnSpan(2),

                            ]),
                    ])
                    ->heading('Data Mahasiswa')
                    ->description('Pastikan semua data yang dimasukkan sudah benar')
                    ->icon('heroicon-o-academic-cap')
            ])
            ->statePath('data');
    }

    public function create(): void
    {
//        dd($this->form->getState());

        $data = $this->form->getState();

        Mahasiswa::create($data);

        Notification::make()
            ->title("Data Berhasil Disimpan")
            ->success()
            ->send();

        $this->redirect(route('filament.user.resources.pengajuan.index'));

    }
}
