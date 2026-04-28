<?php

namespace App\Filament\Resources\TahunAkademiks;

use App\Filament\Resources\TahunAkademiks\Pages\CreateTahunAkademik;
use App\Filament\Resources\TahunAkademiks\Pages\EditTahunAkademik;
use App\Filament\Resources\TahunAkademiks\Pages\ListTahunAkademiks;
use App\Filament\Resources\TahunAkademiks\Schemas\TahunAkademikForm;
use App\Filament\Resources\TahunAkademiks\Tables\TahunAkademiksTable;
use App\Models\TahunAkademik;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TahunAkademikResource extends Resource
{
    protected static ?string $model = TahunAkademik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bookmark;

    protected static ?int $navigationSort = 9;

    protected static string|UnitEnum|null $navigationGroup = 'Data Master';

    protected static ?string $recordTitleAttribute = 'TahunAkademik';

    protected static ?string $navigationLabel = 'Tahun Akademik';


    public static function form(Schema $schema): Schema
    {
        return TahunAkademikForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TahunAkademiksTable::configure($table);
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
            'index' => ListTahunAkademiks::route('/'),
            'create' => CreateTahunAkademik::route('/create'),
            'edit' => EditTahunAkademik::route('/{record}/edit'),
        ];
    }
}
