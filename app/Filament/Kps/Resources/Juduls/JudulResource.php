<?php

namespace App\Filament\Kps\Resources\Juduls;

use App\Filament\Kps\Resources\Juduls\Pages\CreateJudul;
use App\Filament\Kps\Resources\Juduls\Pages\EditJudul;
use App\Filament\Kps\Resources\Juduls\Pages\ListJuduls;
use App\Filament\Kps\Resources\Juduls\Schemas\JudulForm;
use App\Filament\Kps\Resources\Juduls\Tables\JudulsTable;
use App\Models\Judul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class JudulResource extends Resource
{
    protected static ?string $model = Judul::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static string | UnitEnum | null $navigationGroup  = 'Tugas Akhir';

    protected static ?string $navigationLabel = 'Data Judul';

    protected static ?string $modelLabel = 'Judul';

    protected static ?string $pluralModelLabel = 'Daftar Judul';

    protected static ?string $recordTitleAttribute = 'Judul';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return JudulForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JudulsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $prodiId = $user?->prodi_id;

        return parent::getEloquentQuery()
            ->with(['mahasiswa.prodi'])
            ->whereHas('mahasiswa', function (Builder $query) use ($prodiId) {
                $query->where('prodi_id', $prodiId);
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJuduls::route('/'),
            'create' => CreateJudul::route('/create'),
            'edit' => EditJudul::route('/{record}/edit'),
        ];
    }
}
