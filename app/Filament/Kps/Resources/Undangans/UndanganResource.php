<?php

namespace App\Filament\Kps\Resources\Undangans;

use App\Filament\Kps\Resources\Undangans\Pages\CreateUndangan;
use App\Filament\Kps\Resources\Undangans\Pages\EditUndangan;
use App\Filament\Kps\Resources\Undangans\Pages\ListUndangans;
use App\Filament\Kps\Resources\Undangans\Pages\ViewUndangan;
use App\Filament\Kps\Resources\Undangans\Schemas\UndanganForm;
use App\Filament\Kps\Resources\Undangans\Tables\UndangansTable;
use App\Models\Undangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class UndanganResource extends Resource
{
    protected static ?string $model = Undangan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string | UnitEnum | null $navigationGroup = 'Tugas Akhir';

    protected static ?string $navigationLabel = 'Undangan Sidang';

    protected static ?string $modelLabel = 'Undangan';

    protected static ?string $pluralModelLabel = 'Daftar Undangan';

    protected static ?string $recordTitleAttribute = 'Undangan';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return UndanganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UndangansTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $prodiId = $user?->prodi_id;

        return parent::getEloquentQuery()
            ->with(['judul.mahasiswa.prodi'])
            ->whereHas('judul.mahasiswa', function (Builder $query) use ($prodiId) {
                $query->where('prodi_id', $prodiId);
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUndangans::route('/'),
            'create' => CreateUndangan::route('/create'),
            'view' => ViewUndangan::route('/{record}'),
            'edit' => EditUndangan::route('/{record}/edit'),
        ];
    }
}
