<?php

namespace App\Filament\Resources\Dosens;

use App\Filament\Resources\Dosens\Pages\CreateDosen;
use App\Filament\Resources\Dosens\Pages\EditDosen;
use App\Filament\Resources\Dosens\Pages\ListDosens;
use App\Filament\Resources\Dosens\Schemas\DosenForm;
use App\Filament\Resources\Dosens\Tables\DosensTable;
use App\Models\Dosen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DosenResource extends Resource
{
    protected static ?string $model = Dosen::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-s-academic-cap';

    protected static string | UnitEnum | null $navigationGroup = "Data Master";

    protected static ?string $navigationLabel = "Dosen";
    protected static ?int $navigationSort = 11;

//    protected static ?string $recordTitleAttribute = 'Dosenss';

    public static function canAccess(): bool
    {
        if (auth()->user()->role === 'admin'){
            return true;
        } elseif(auth()->user()->role === 'akademik'){
            return true;
        }
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return DosenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DosensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

//    public static function canAccess(): bool
//    {
//        return str_ends_with(auth()->user()->role, 'admin');
//    }

    public static function getPages(): array
    {
        return [
            'index' => ListDosens::route('/'),
            'create' => CreateDosen::route('/create'),
            'edit' => EditDosen::route('/{record}/edit'),
        ];
    }
}
