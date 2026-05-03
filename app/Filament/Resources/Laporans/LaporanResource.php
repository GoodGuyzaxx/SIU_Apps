<?php

namespace App\Filament\Resources\Laporans;

use App\Filament\Resources\Laporans\Pages\CreateLaporan;
use App\Filament\Resources\Laporans\Pages\EditLaporan;
use App\Filament\Resources\Laporans\Pages\ListLaporans;
use App\Filament\Resources\Laporans\Schemas\LaporanForm;
use App\Filament\Resources\Laporans\Tables\LaporansTable;
use App\Filament\Resources\Laporans\Widgets\RekapanStasWidget;
use App\Models\Judul;
use App\Models\Laporan;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Undangan;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LaporanResource extends Resource
{
    protected static ?string $model = Judul::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 9;

    protected static string|UnitEnum|null $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Rekapan';

    protected static ?string $breadcrumb = 'Rekapan';

//    public static function form(Schema $schema): Schema
//    {
//        return LaporanForm::configure($schema);
//    }

    public static function table(Table $table): Table
    {
        return LaporansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }
    public static function getWidgets(): array
    {
        return [
            RekapanStasWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLaporans::route('/'),
        ];
    }
}
