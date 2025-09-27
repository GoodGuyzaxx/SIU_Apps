<?php

namespace App\Filament\Resources\Juduls;

use App\Filament\Resources\Juduls\Pages\CreateJudul;
use App\Filament\Resources\Juduls\Pages\EditJudul;
use App\Filament\Resources\Juduls\Pages\ListJuduls;
use App\Filament\Resources\Juduls\Pages\ViewJudul;
use App\Filament\Resources\Juduls\Schemas\JudulForm;
use App\Filament\Resources\Juduls\Tables\JudulsTable;
use App\Models\Judul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JudulResource extends Resource
{
    protected static ?string $model = Judul::class;

    protected static ?string $slug = 'judul';

    protected static ?string $breadcrumb = 'Judul';


    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = "Judul";


//    protected static ?string $recordTitleAttribute = 'Judul';

    public static function form(Schema $schema): Schema
    {
        return JudulForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JudulsTable::configure($table);
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
            'view' => ViewJudul::route('/{record}'),
            'edit' => EditJudul::route('/{record}/edit'),
        ];
    }
}
