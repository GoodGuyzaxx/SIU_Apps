<?php

namespace App\Filament\Kps\Resources\Laporans;

use App\Filament\Kps\Resources\Laporans\Pages\ListKpsLaporans;
use App\Filament\Kps\Resources\Laporans\Tables\KpsLaporansTable;
use App\Models\Judul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class KpsLaporanResource extends Resource
{
    protected static ?string $model = Judul::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Rekapan / Laporan';

    protected static ?string $breadcrumb = 'Rekapan / Laporan';

    protected static ?string $modelLabel = 'Laporan';

    protected static ?string $pluralModelLabel = 'Rekapan Laporan';

    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        $user    = auth()->user();
        $prodiId = $user?->prodi_id;

        return parent::getEloquentQuery()
            ->with([
                'mahasiswa.prodi',
                'tahunAkademik',
                'nilai',
                'pembimbingSatu',
                'pembimbingDua',
                'pengujiSatu',
                'pengujiDua',
            ])
            ->whereHas('mahasiswa', function (Builder $query) use ($prodiId) {
                $query->where('prodi_id', $prodiId);
            });
    }

    public static function table(Table $table): Table
    {
        return KpsLaporansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKpsLaporans::route('/'),
        ];
    }
}
