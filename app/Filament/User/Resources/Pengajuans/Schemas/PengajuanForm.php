<?php

namespace App\Filament\User\Resources\Pengajuans\Schemas;

use App\Models\Mahasiswa;
use App\Models\UsulanJudul;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class PengajuanForm
{
    public static function configure(Schema $schema): Schema
    {
        $dataId = Mahasiswa::where("id_user", auth()->id())->first();

        return $schema->components([
            Hidden::make("id_mahasiswa")->default($dataId?->id),

            // Card 1: Minat Kekhususan
            Section::make()
                ->schema([
                    Grid::make(1)->schema([
                        Select::make("minat_kekuhusan")
                            ->label("Pilih Minat Kekhususan")
                            ->placeholder("-- Pilih Minat Kekhususan --")
                            ->required()
                            ->options([
                                "HTN" => "📚 Hukum Tata Negara (HTN)",
                                "Hukum Pidana" => "⚖️ Hukum Pidana",
                                "Hukum Perdata" => "📝 Hukum Perdata",
                            ])
                            ->native(false)
                            ->searchable()
                            ->prefixIcon("heroicon-m-book-open")
                            ->suffixIcon("heroicon-m-chevron-down")
                            ->helperText(
                                "Pilih bidang hukum yang paling Anda minati",
                            )
                            ->live()
                            ->columnSpanFull(),

                        // Dynamic info based on selection
                        Placeholder::make("minat_description")
                            ->label("")
                            ->content(
                                fn($get) => match ($get("minat_kekuhusan")) {
                                    "HTN"
                                        => "Hukum Tata Negara Mempelajari konstitusi, struktur pemerintahan, hubungan antar lembaga negara, dan hak asasi manusia.",
                                    "Hukum Pidana"
                                        => "Mempelajari tindak pidana, sanksi hukum, sistem peradilan pidana, dan penegakan hukum",
                                    "Hukum Perdata"
                                        => "Mempelajari hubungan hukum antar individu, kontrak, warisan, dan kepemilikan.",
                                    default => "",
                                },
                            )
                            ->hidden(fn($get) => empty($get("minat_kekuhusan")))
                            ->columnSpanFull(),
                    ]),
                ])
                ->heading("1️⃣ Minat Kekhususan")
                ->description("Pilih bidang kekhususan hukum yang Anda minati")
                ->icon("heroicon-o-academic-cap")
                ->extraAttributes(["class" => "p-6"])
                ->columnSpanFull(),

            // Alternative: Without Repeater (Original 3 fields)
            Section::make()
                ->schema([
                    // Judul 1
                    Grid::make(1)
                        ->schema([
                            Textarea::make("judul_satu")
                                ->label("📌 Prioritas 1")
                                ->placeholder(
                                    "Contoh: Analisis Hukum Terhadap Implementasi Peraturan...",
                                )
                                ->required()
                                ->minLength(10)
                                ->maxLength(500)
                                ->rows(3)
                                ->autosize()
                                ->helperText(
                                    fn($get) => strlen(
                                        $get("judul_satu") ?? "",
                                    ) . "/500 karakter",
                                )
                                ->live(onBlur: true)
                                ->columnSpanFull(),
                        ])
                        ->extraAttributes([
                            "class" =>
                                "p-4 bg-primary-50 dark:bg-primary-900/10 rounded-lg",
                        ]),

                    // Judul 2
                    Grid::make(1)
                        ->schema([
                            Textarea::make("judul_dua")
                                ->label("📌 Prioritas 2")
                                ->placeholder(
                                    "Contoh: Tinjauan Yuridis Mengenai...",
                                )
                                ->required()
                                ->minLength(10)
                                ->maxLength(500)
                                ->rows(3)
                                ->autosize()
                                ->helperText(
                                    fn($get) => strlen(
                                        $get("judul_dua") ?? "",
                                    ) . "/500 karakter",
                                )
                                ->live(onBlur: true)
                                ->columnSpanFull(),
                        ])
                        ->extraAttributes([
                            "class" =>
                                "p-4 bg-gray-50 dark:bg-gray-900/10 rounded-lg",
                        ]),

                    // Judul 3
                    Grid::make(1)
                        ->schema([
                            Textarea::make("judul_tiga")
                                ->label("📌 Prioritas 3")
                                ->placeholder(
                                    "Contoh: Implementasi dan Penerapan...",
                                )
                                ->required()
                                ->minLength(10)
                                ->maxLength(500)
                                ->rows(3)
                                ->autosize()
                                ->helperText(
                                    fn($get) => strlen(
                                        $get("judul_tiga") ?? "",
                                    ) . "/500 karakter",
                                )
                                ->live(onBlur: true)
                                ->columnSpanFull(),
                        ])
                        ->extraAttributes([
                            "class" =>
                                "p-4 bg-gray-50 dark:bg-gray-900/10 rounded-lg",
                        ]),
                ])
                ->heading("2️⃣ Usulan Judul Penelitian")
                ->description(
                    "Masukkan 3 usulan judul penelitian sesuai prioritas",
                )
                ->icon("heroicon-o-document-text")
                ->extraAttributes(["class" => "p-6 mt-4 space-y-4"])
                ->columnSpanFull(),

            // Tips Section
            Section::make()
                ->schema([
                    Placeholder::make("tips")->label("")->content(
                        new \Illuminate\Support\HtmlString('
                            <div class="space-y-3">
                                <div class="flex items-start gap-2">
                                    <span class="text-green-600 dark:text-green-400">✓</span>
                                    <span class="text-sm">Judul harus jelas dan spesifik</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="text-green-600 dark:text-green-400">✓</span>
                                    <span class="text-sm">Sesuaikan dengan minat kekhususan</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="text-green-600 dark:text-green-400">✓</span>
                                    <span class="text-sm">Minimal 10 karakter per judul</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="text-green-600 dark:text-green-400">✓</span>
                                    <span class="text-sm">Judul dapat diubah sebelum disetujui</span>
                                </div>
                            </div>
                        '),
                    ),
                ])
                ->heading("💡 Tips Membuat Judul")
                ->icon("heroicon-o-light-bulb")
                ->extraAttributes(["class" => "p-4 mt-4"])
                ->collapsed()
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }


    //    public static function configure(Schema $schema): Schema
    //    {
    //        $dataId = Mahasiswa::where('id_user' , auth()->id())->first();
    //
    //        return $schema
    //            ->components([
    //                Section::make()
    //                ->schema([
    //                    Hidden::make('id_mahasiswa')
    //                        ->default($dataId->id),
    //
    //                    Select::make('minat_kekuhusan')
    //                        ->label('Minat Kekuhusan')
    //                        ->placeholder('Minat Kekuhusan')
    //                        ->required()
    //                        ->options([
    //                            'HTN' => 'HTN',
    //                            'Hukum Pidana' => 'Hukum Pidana',
    //                            'Hukum Perdata' => 'Hukum Perdata',
    //                        ])
    //                    ->native(false)
    //                    ->prefixIcon('heroicon-o-book-open'),
    //
    //                    Textarea::make('judul_satu')
    //                        ->label("Judul Pertama")
    //                        ->required()
    //                        ->minLength(3),
    //
    //                    Textarea::make('judul_dua')
    //                        ->label("Judul Kedua")
    //                        ->required()
    //                        ->minLength(3),
    //
    //                    Textarea::make('judul_tiga')
    //                        ->label("Judul Ketiga")
    //                        ->required()
    //                        ->minLength(3)
    //
    //                ])
    //            ]);
    //    }
}
