<?php

namespace App\Filament\Kps\Resources\PengajuanJuduls\Tables;

use App\Filament\Kps\Resources\PengajuanJuduls\Pages\DetailPengajuan;
use App\Models\UsulanJudul;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuanJudulsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Nomor urut
                TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter()
                    ->width('60px'),

                // Nama mahasiswa
                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->icon('heroicon-o-user-circle')
                    ->description(fn ($record) => $record->mahasiswa?->npm ?? '-'),

                // Program studi
                TextColumn::make('mahasiswa.prodi.nama_prodi')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-academic-cap'),

                // Minat / peminatan
                TextColumn::make('minat_kekuhusan')
                    ->label('Minat / Peminatan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                // Judul pertama (utama)
                TextColumn::make('judul_satu')
                    ->label('Judul Utama (Pilihan 1)')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->judul_satu)
                    ->wrap(),

                // Status badge
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (string $state): string => match ($state) {
                        'Disetujui'  => 'success',
                        'Ditolak'    => 'danger',
                        'Pengajuan'  => 'warning',
                        default      => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Disetujui'  => 'heroicon-o-check-circle',
                        'Ditolak'    => 'heroicon-o-x-circle',
                        'Pengajuan'  => 'heroicon-o-clock',
                        default      => 'heroicon-o-question-mark-circle',
                    })
                    ->sortable(),

                // Tanggal pengajuan
                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at?->format('d M Y, H:i'))
                    ->color('gray'),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->default('Pengajuan')
                    ->options([
                        'Pengajuan'  => 'Menunggu Review',
                        'Disetujui'  => 'Disetujui',
                        'Ditolak'    => 'Ditolak',
                    ])
                    ->placeholder('Semua Status'),
            ])

            ->recordActions([
                Action::make("Detail")
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn(UsulanJudul $record) => DetailPengajuan::getUrl([$record->id]))
            ])

            ->toolbarActions([
                BulkActionGroup::make([]),
            ])

            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->poll('30s')
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateHeading('Belum Ada Pengajuan Judul')
            ->emptyStateDescription('Tidak ada data pengajuan judul dari mahasiswa prodi Anda saat ini.');
    }
}
