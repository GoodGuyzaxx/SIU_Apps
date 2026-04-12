<?php

namespace App\Filament\Resources\ConfigDokumens;

use App\Filament\Resources\ConfigDokumens\Pages\CreateConfigDokumen;
use App\Filament\Resources\ConfigDokumens\Pages\EditConfigDokumen;
use App\Filament\Resources\ConfigDokumens\Pages\ListConfigDokumens;
use App\Filament\Resources\ConfigDokumens\Schemas\ConfigDokumenForm;
use App\Filament\Resources\ConfigDokumens\Tables\ConfigDokumensTable;
use App\Models\ConfigDokumen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ConfigDokumenResource extends Resource
{
    protected static ?string $model = ConfigDokumen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ConfigDokumen';

    protected static ?string $navigationLabel = 'Config Dokumen';

    protected static string | UnitEnum | null $navigationGroup ='Data Master';


    protected static ?int $navigationSort = 12;

    public static function form(Schema $schema): Schema
    {
        return ConfigDokumenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfigDokumensTable::configure($table);
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
            'index' => ListConfigDokumens::route('/'),
            'create' => CreateConfigDokumen::route('/create'),
            'edit' => EditConfigDokumen::route('/{record}/edit'),
        ];
    }
}
