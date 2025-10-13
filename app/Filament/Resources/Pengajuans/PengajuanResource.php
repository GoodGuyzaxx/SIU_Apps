<?php

namespace App\Filament\Resources\Pengajuans;

use App\Filament\Resources\Pengajuans\Pages\CreatePengajuan;
use App\Filament\Resources\Pengajuans\Pages\DetailPengajuan;
use App\Filament\Resources\Pengajuans\Pages\EditPengajuan;
use App\Filament\Resources\Pengajuans\Pages\ListPengajuans;
use App\Filament\Resources\Pengajuans\Schemas\PengajuanForm;
use App\Filament\Resources\Pengajuans\Tables\PengajuansTable;
use App\Models\UsulanJudul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PengajuanResource extends Resource
{
    protected static ?string $model = UsulanJudul::class;

    protected static ?string $slug = 'pengajuan';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = "Pengajuan Judul";

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $recordTitleAttribute = 'UsulanJudul';

    public static function form(Schema $schema): Schema
    {
        return PengajuanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajuansTable::configure($table);
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
            'index' => ListPengajuans::route('/'),
            'create' => CreatePengajuan::route('/create'),
            'edit' => EditPengajuan::route('/{record}/edit'),
            'detail' => DetailPengajuan::route('/{record}/detail'),
        ];
    }
}
