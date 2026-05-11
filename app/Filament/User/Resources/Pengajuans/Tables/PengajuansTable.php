<?php

namespace App\Filament\User\Resources\Pengajuans\Tables;

use App\Filament\User\Resources\Pengajuans\Pages\DetailPengajuan;
use App\Models\Mahasiswa;
use App\Models\UsulanJudul;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PengajuansTable
{
    public static function configure(Table $table): Table
    {
        $mahasiswa = Mahasiswa::where('id_user', auth()->id())->first();

        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter()
                    ->width('60px'),

                TextColumn::make('minat_kekuhusan')
                    ->label('Minat / Peminatan')
                    ->searchable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('judul_satu')
                    ->label('Judul Utama (Pilihan 1)')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->judul_satu)
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (string $state): string => match ($state) {
                        'Disetujui' => 'success',
                        'Ditolak'   => 'danger',
                        'Pengajuan' => 'warning',
                        default     => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Disetujui' => 'heroicon-o-check-circle',
                        'Ditolak'   => 'heroicon-o-x-circle',
                        'Pengajuan' => 'heroicon-o-clock',
                        default     => 'heroicon-o-question-mark-circle',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at?->format('d M Y, H:i'))
                    ->color('gray'),
            ])
            ->modifyQueryUsing(function ($query) use ($mahasiswa) {
                if ($mahasiswa) {
                    return $query->where('id_mahasiswa', $mahasiswa->id);
                }
                return $query->whereRaw('1 = 0');
            })
            ->heading('Pengajuan Judul Saya')
            ->description($mahasiswa
                ? "Menampilkan pengajuan untuk: {$mahasiswa->nama} (NPM: {$mahasiswa->npm})"
                : 'Tidak ada data mahasiswa'
            )
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->recordActions([
                Action::make('Detail')
                    ->label('Detail')
                    ->color('success')
                    ->icon('heroicon-o-eye')
                    ->url(fn (UsulanJudul $record) => DetailPengajuan::getUrl([$record->id])),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->emptyStateHeading('Belum Ada Pengajuan')
            ->emptyStateDescription('Anda belum membuat pengajuan judul skripsi.')
            ->emptyStateActions([]);
    }
}
