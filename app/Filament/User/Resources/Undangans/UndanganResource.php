<?php

namespace App\Filament\User\Resources\Undangans;

use App\Filament\User\Resources\Undangans\Pages\CreateUndangan;
use App\Filament\User\Resources\Undangans\Pages\DetailUndangan;
use App\Filament\User\Resources\Undangans\Pages\EditUndangan;
use App\Filament\User\Resources\Undangans\Pages\ListUndangans;
use App\Filament\User\Resources\Undangans\Schemas\UndanganForm;
use App\Filament\User\Resources\Undangans\Tables\UndangansTable;
use App\Models\Mahasiswa;
use App\Models\Undangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class UndanganResource extends Resource
{
    protected static ?string $model = Undangan::class;

    protected static ?string $navigationLabel = "Daftar Undangan";

    protected static ?string $breadcrumb = 'Daftar Undangan';

    protected static ?string $slug = "undangan";

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    public static function shouldRegisterNavigation(): bool
    {
        $dataMhs = Mahasiswa::find(auth()->id());

        return $dataMhs === null;
    }

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
            'detail' => DetailUndangan::route('/{record}/detail'),
//            'create' => CreateUndangan::route('/create'),
//            'edit' => EditUndangan::route('/{record}/edit'),
        ];
    }
}
