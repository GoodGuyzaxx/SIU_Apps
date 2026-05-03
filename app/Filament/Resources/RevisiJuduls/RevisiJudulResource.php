<?php

namespace App\Filament\Resources\RevisiJuduls;

use App\Filament\Resources\RevisiJuduls\Pages\CreateRevisiJudul;
use App\Filament\Resources\RevisiJuduls\Pages\EditRevisiJudul;
use App\Filament\Resources\RevisiJuduls\Pages\ListRevisiJuduls;
use App\Filament\Resources\RevisiJuduls\Schemas\RevisiJudulForm;
use App\Filament\Resources\RevisiJuduls\Tables\RevisiJudulsTable;
use App\Models\Judul;
use App\Models\RevisiJudul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RevisiJudulResource extends Resource
{
    protected static ?string $model = Judul::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::PencilSquare;

    protected static ?string $recordTitleAttribute = 'Revisi Judul';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?string $navigationLabel = 'Revisi Judul';

    protected static ?string $breadcrumb = 'Revisi Judul';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return RevisiJudulForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RevisiJudulsTable::configure($table);
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
            'index' => ListRevisiJuduls::route('/'),
        ];
    }
}
