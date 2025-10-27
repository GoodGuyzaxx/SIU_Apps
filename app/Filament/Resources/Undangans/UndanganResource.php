<?php

namespace App\Filament\Resources\Undangans;

use App\Filament\Resources\Undangans\Pages\CreateUndangan;
use App\Filament\Resources\Undangans\Pages\EditUndangan;
use App\Filament\Resources\Undangans\Pages\ListUndangans;
use App\Filament\Resources\Undangans\Pages\ViewUndangan;
use App\Filament\Resources\Undangans\Schemas\UndanganForm;
use App\Filament\Resources\Undangans\Tables\UndangansTable;
use App\Models\Undangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class UndanganResource extends Resource
{
    protected static ?string $model = Undangan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string | BackedEnum | null $activeNavigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = "Undangan";

    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'undangan';

    protected static ?string $breadcrumb = 'Undangan';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

//    protected static ?string $recordTitleAttribute = 'Undangan';

    public static function form(Schema $schema): Schema
    {
        return UndanganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UndangansTable::configure($table);
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
            'index' => ListUndangans::route('/'),
            'create' => CreateUndangan::route('/create'),
            'view' => ViewUndangan::route('/{record}'),
            'edit' => EditUndangan::route('/{record}/edit'),
        ];
    }
}
