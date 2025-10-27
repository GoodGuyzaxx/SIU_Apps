<?php

namespace App\Filament\User\Resources\Pengajuans;

use App\Filament\User\Resources\Pengajuans\Pages\CreatePengajuan;
use App\Filament\User\Resources\Pengajuans\Pages\DetailPengajuan;
use App\Filament\User\Resources\Pengajuans\Pages\ListPengajuans;
use App\Filament\User\Resources\Pengajuans\Schemas\PengajuanForm;
use App\Filament\User\Resources\Pengajuans\Tables\PengajuansTable;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\UsulanJudul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PengajuanResource extends Resource
{
    protected static ?string $model = UsulanJudul::class;

    protected static ?string $slug = 'pengajuan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Pengajuan Judul';

    public function hideNav(): bool {
        $id = Auth::user()->id;
        $idMhs = Mahasiswa::where('id_user', $id)->first();
        if ($idMhs !== null) {
            return true;
        }
        return false;

    }

    public static function shouldRegisterNavigation(): bool
    {
        $instance = new static();
        return $instance->hideNav();
    }
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

            'detail' => DetailPengajuan::route('/{record}/detail'),
//            'edit' => EditPengajuan::route('/{record}/edit'),
        ];
    }
}
