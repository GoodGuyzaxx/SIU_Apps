<?php

namespace App\Filament\Kps\Resources\Mahasiswas;

use App\Filament\Kps\Resources\Mahasiswas\Pages\CreateMahasiswa;
use App\Filament\Kps\Resources\Mahasiswas\Pages\EditMahasiswa;
use App\Filament\Kps\Resources\Mahasiswas\Pages\ListMahasiswas;
use App\Filament\Kps\Resources\Mahasiswas\Schemas\MahasiswaForm;
use App\Filament\Kps\Resources\Mahasiswas\Tables\MahasiswasTable;
use App\Models\Mahasiswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

     protected static string | UnitEnum | null $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Data Mahasiswa';

    protected static ?string $modelLabel = 'Mahasiswa';

    protected static ?string $pluralModelLabel = 'Daftar Mahasiswa';

    protected static ?string $recordTitleAttribute = 'Mahasiswa';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return MahasiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MahasiswasTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $prodiId = $user?->prodi_id;

        return parent::getEloquentQuery()
            ->with(['prodi'])
            ->whereHas('prodi', function (Builder $query) use ($prodiId) {
                $query->where('prodi_id', $prodiId);
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMahasiswas::route('/'),
            'edit' => EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
