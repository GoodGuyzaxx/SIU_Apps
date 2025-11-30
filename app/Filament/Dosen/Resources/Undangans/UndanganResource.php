<?php

namespace App\Filament\Dosen\Resources\Undangans;

use App\Filament\Dosen\Resources\Undangans\Pages\CreateUndangan;
use App\Filament\Dosen\Resources\Undangans\Pages\DetailUndangan;
use App\Filament\Dosen\Resources\Undangans\Pages\EditUndangan;
use App\Filament\Dosen\Resources\Undangans\Pages\ListUndangans;
use App\Filament\Dosen\Resources\Undangans\Schemas\UndanganForm;
use App\Filament\Dosen\Resources\Undangans\Tables\UndangansTable;
use App\Models\Undangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UndanganResource extends Resource
{
    protected static ?string $model = Undangan::class;

    protected static ?string $navigationLabel = 'Undangan';

    protected static ?string $breadcrumb ='Undangan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

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
            'detail' => DetailUndangan::route('/{record}'),
//            'create' => CreateUndangan::route('/create'),
//            'edit' => EditUndangan::route('/{record}/edit'),
        ];
    }
}
