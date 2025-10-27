<?php

namespace App\Filament\User\Resources\Pengajuans\Schemas;

use App\Models\Mahasiswa;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PengajuanForm
{
    public static function configure(Schema $schema): Schema
    {
        $dataId = Mahasiswa::where("id_user", auth()->id())->first();

        return $schema->components([
            Section::make()
                ->schema([
                    Hidden::make("id_mahasiswa")->default($dataId?->id),
                    Grid::make(1)
                        ->schema([
                            Select::make("minat_kekuhusan")
                                ->label("🎯 Minat Kekhususan")
                                ->placeholder("Pilih bidang hukum yang Anda minati...")
                                ->required()
                                ->options([
                                    "HTN" => "🏛️ Hukum Tata Negara (HTN)",
                                    "Hukum Pidana" => "⚖️ Hukum Pidana",
                                    "Hukum Perdata" => "📄 Hukum Perdata",
                                ])
                                ->native(false)
                                ->searchable()
                                ->prefixIcon("heroicon-o-academic-cap")
                                ->suffixIcon("heroicon-m-chevron-down")
                                ->helperText("Pilih satu bidang kekhususan yang paling sesuai dengan minat penelitian Anda")
                                ->live()
                                ->columnSpanFull(),

                            // Enhanced Dynamic Description
                            Section::make()
                                ->schema([
                                    Placeholder::make("minat_description")
                                        ->label('')
                                        ->content(
                                            fn($get) => match ($get("minat_kekuhusan")) {
                                                "HTN" => new \Illuminate\Support\HtmlString('
                                                        <div class="space-y-2">
                                                            <div class="font-semibold text-primary-600">🏛️ Hukum Tata Negara (HTN)</div>
                                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                                Mempelajari konstitusi, struktur pemerintahan, hubungan antar lembaga negara,
                                                                dan hak asasi manusia. Cocok untuk penelitian tentang sistem ketatanegaraan.
                                                            </div>
                                                        </div>
                                                    '),
                                                "Hukum Pidana" => new \Illuminate\Support\HtmlString('
                                                        <div class="space-y-2">
                                                            <div class="font-semibold text-primary-600">⚖️ Hukum Pidana</div>
                                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                                Mempelajari tindak pidana, sanksi hukum, sistem peradilan pidana, dan penegakan hukum.
                                                                Ideal untuk analisis kasus-kasus pidana dan sistem peradilan.
                                                            </div>
                                                        </div>
                                                    '),
                                                "Hukum Perdata" => new \Illuminate\Support\HtmlString('
                                                        <div class="space-y-2">
                                                            <div class="font-semibold text-primary-600">📄 Hukum Perdata</div>
                                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                                Mempelajari hubungan hukum antar individu, kontrak, warisan, dan kepemilikan.
                                                                Sesuai untuk penelitian tentang hubungan hukum privat.
                                                            </div>
                                                        </div>
                                                    '),
                                                default => '',
                                            }
                                        )
                                        ->hidden(fn($get) => empty($get("minat_kekuhusan")))
                                ])
                                ->hidden(fn($get) => empty($get("minat_kekuhusan")))
                                ->extraAttributes(['class' => 'bg-primary-50/50 border-primary-200 dark:bg-primary-900/20'])
                                ->columnSpanFull(),
                        ])
                ])
                ->heading("🎓 Peminatan Hukum")
                ->description("Tentukan bidang kekhususan yang menjadi fokus penelitian Anda")
                ->icon("heroicon-o-academic-cap")
                ->extraAttributes(["class" => "p-6 border-l-4 border-l-primary-500 bg-white dark:bg-gray-800 shadow-sm"])
                ->columnSpanFull(),

            // Card 2: Usulan Judul - Enhanced Visual Hierarchy
            Section::make()
                ->schema([
                    Grid::make(1)
                        ->schema([
                            // Priority 1 - Highlighted
                            Section::make()
                                ->schema([
                                    Textarea::make("judul_satu")
                                        ->label("🥇 Judul Prioritas Utama")
                                        ->placeholder("Contoh: Analisis Hukum Terhadap Implementasi Peraturan Daerah Tentang...")
                                        ->required()
                                        ->minLength(10)
                                        ->maxLength(500)
                                        ->rows(3)
                                        ->autosize()
                                        ->helperText(fn($get) =>
                                            strlen($get("judul_satu") ?? "") . "/500 karakter • Judul prioritas pertama yang paling Anda minati"
                                        )
                                        ->live(onBlur: true)
                                        ->columnSpanFull(),
                                ])
                                ->extraAttributes([
                                    "class" => "border-l-4 border-l-amber-500 bg-amber-50/50 dark:bg-amber-900/20 shadow-sm"
                                ]),

                            // Priority 2
                            Section::make()
                                ->schema([
                                    Textarea::make("judul_dua")
                                        ->label("🥈 Judul Prioritas Kedua")
                                        ->placeholder("Contoh: Tinjauan Yuridis Mengenai Pengaturan Hukum Terhadap...")
                                        ->required()
                                        ->minLength(10)
                                        ->maxLength(500)
                                        ->rows(3)
                                        ->autosize()
                                        ->helperText(fn($get) =>
                                            strlen($get("judul_dua") ?? "") . "/500 karakter • Alternatif judul penelitian"
                                        )
                                        ->live(onBlur: true)
                                        ->columnSpanFull(),
                                ])
                                ->extraAttributes([
                                    "class" => "border-l-4 border-l-blue-500 bg-blue-50/50 dark:bg-blue-900/20 shadow-sm"
                                ]),

                            // Priority 3
                            Section::make()
                                ->schema([
                                    Textarea::make("judul_tiga")
                                        ->label("🥉 Judul Prioritas Ketiga")
                                        ->placeholder("Contoh: Implementasi dan Penerapan Asas-Asas Hukum Dalam...")
                                        ->required()
                                        ->minLength(10)
                                        ->maxLength(500)
                                        ->rows(3)
                                        ->autosize()
                                        ->helperText(fn($get) =>
                                            strlen($get("judul_tiga") ?? "") . "/500 karakter • Opsi tambahan judul penelitian"
                                        )
                                        ->live(onBlur: true)
                                        ->columnSpanFull(),
                                ])
                                ->extraAttributes([
                                    "class" => "border-l-4 border-l-green-500 bg-green-50/50 dark:bg-green-900/20 shadow-sm"
                                ]),
                        ])
                        ->extraAttributes(['class' => 'space-y-4'])
                ])
                ->heading("📝 Usulan Judul Penelitian")
                ->description("Berikan 3 usulan judul penelitian sesuai dengan urutan prioritas")
                ->icon("heroicon-o-document-text")
                ->extraAttributes(["class" => "p-6 border-l-4 border-l-blue-500 bg-white dark:bg-gray-800 shadow-sm"])
                ->columnSpanFull(),

            // Card 3: Tips - More Comprehensive
            Section::make()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            // Left Column - Basic Tips
                            Section::make()
                                ->schema([
                                    Placeholder::make('basic_tips')
                                        ->label('Tips Dasar')
                                        ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-3">
                                                    <div class="flex items-start gap-3 p-3 rounded-lg bg-green-50 dark:bg-green-900/20">
                                                        <span class="text-green-600 dark:text-green-400 mt-0.5">✓</span>
                                                        <div class="space-y-1">
                                                            <div class="font-medium text-sm">Judul Spesifik dan Jelas</div>
                                                            <div class="text-xs text-gray-600 dark:text-gray-400">Hindari judul yang terlalu umum atau ambigu</div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                                                        <span class="text-blue-600 dark:text-blue-400 mt-0.5">✓</span>
                                                        <div class="space-y-1">
                                                            <div class="font-medium text-sm">Sesuai Minat Kekhususan</div>
                                                            <div class="text-xs text-gray-600 dark:text-gray-400">Pastikan judul relevan dengan bidang yang dipilih</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            '))
                                ])
                                ->columnSpan(1),

                            // Right Column - Technical Tips
                            Section::make()
                                ->schema([
                                    Placeholder::make('technical_tips')
                                        ->label('Tips Teknis')
                                        ->content(new \Illuminate\Support\HtmlString('
                                                <div class="space-y-3">
                                                    <div class="flex items-start gap-3 p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20">
                                                        <span class="text-purple-600 dark:text-purple-400 mt-0.5">📏</span>
                                                        <div class="space-y-1">
                                                            <div class="font-medium text-sm">Panjang Optimal</div>
                                                            <div class="text-xs text-gray-600 dark:text-gray-400">10-15 kata, maksimal 500 karakter</div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-start gap-3 p-3 rounded-lg bg-amber-50 dark:bg-amber-900/20">
                                                        <span class="text-amber-600 dark:text-amber-400 mt-0.5">✏️</span>
                                                        <div class="space-y-1">
                                                            <div class="font-medium text-sm">Dapat Disesuaikan</div>
                                                            <div class="text-xs text-gray-600 dark:text-gray-400">Judul dapat diubah sebelum disetujui dosen</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            '))
                                ])
                                ->columnSpan(1),
                        ])
                ])
                ->heading("💡 Panduan Penyusunan Judul")
                ->description("Tips dan panduan untuk membuat judul penelitian yang baik")
                ->icon("heroicon-o-light-bulb")
                ->extraAttributes(["class" => "p-6 border-l-4 border-l-amber-500 bg-white dark:bg-gray-800 shadow-sm"])
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
