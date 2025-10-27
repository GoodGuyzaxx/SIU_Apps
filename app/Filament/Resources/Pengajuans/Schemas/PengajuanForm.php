<?php

namespace App\Filament\Resources\Pengajuans\Schemas;

use App\Models\Mahasiswa;
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

        ]);
    }
}
