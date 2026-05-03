<?php

namespace App\Filament\Kps\Resources\PengajuanJuduls;

use App\Filament\Kps\Resources\PengajuanJuduls\Pages\CreatePengajuanJudul;
use App\Filament\Kps\Resources\PengajuanJuduls\Pages\DetailPengajuan;
use App\Filament\Kps\Resources\PengajuanJuduls\Pages\EditPengajuanJudul;
use App\Filament\Kps\Resources\PengajuanJuduls\Pages\ListPengajuanJuduls;
use App\Filament\Kps\Resources\PengajuanJuduls\Schemas\PengajuanJudulForm;
use App\Filament\Kps\Resources\PengajuanJuduls\Tables\PengajuanJudulsTable;
use App\Models\UsulanJudul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PengajuanJudulResource extends Resource
{
    protected static ?string $model = UsulanJudul::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string | UnitEnum | null $navigationGroup = 'Tugas Akhir';

    protected static ?string $navigationLabel = 'Pengajuan Judul';

    protected static ?string $modelLabel = 'Pengajuan Judul';

    protected static ?string $pluralModelLabel = 'Daftar Pengajuan Judul';

    protected static ?string $recordTitleAttribute = 'judul_satu';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PengajuanJudulForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajuanJudulsTable::configure($table);
    }

    /**
     * Scope query agar KPS hanya melihat data mahasiswa dari prodi-nya sendiri.
     */
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $prodiId = $user?->prodi_id;

        return parent::getEloquentQuery()
            ->with(['mahasiswa.prodi'])
            ->whereHas('mahasiswa', function (Builder $query) use ($prodiId) {
                $query->where('prodi_id', $prodiId);
            });
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
            'index'  => ListPengajuanJuduls::route('/'),
            'create' => CreatePengajuanJudul::route('/create'),
            'edit'   => EditPengajuanJudul::route('/{record}/edit'),
            'detail'   => DetailPengajuan::route('/{record}/detail'),
        ];
    }
}
