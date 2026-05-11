<?php

namespace App\Filament\Kps\Resources\Laporans\Tables;

use App\Exports\LaporanExport;
use App\Models\Judul;
use App\Models\Prodi;
use App\Models\TahunAkademik;
use Filament\Actions\Action;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class KpsLaporansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('no')
                    ->rowIndex()
                    ->label('No.'),

                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mahasiswa.npm')
                    ->label('NPM')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mahasiswa.prodi.nama_prodi')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('tahunAkademik.takad')
                    ->label('Tahun Akademik')
                    ->formatStateUsing(fn ($record) => "[{$record->tahunAkademik?->takad}-{$record->tahunAkademik?->priode}]-{$record->tahunAkademik?->status}")
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->limit(60)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable(),

                TextColumn::make('pembimbingSatu.nama')
                    ->label('Pembimbing 1')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pembimbingDua.nama')
                    ->label('Pembimbing 2')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pengujiSatu.nama')
                    ->label('Penguji 1')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pengujiDua.nama')
                    ->label('Penguji 2')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('nilai.nilai_proposal')
                    ->label('Nilai Proposal')
                    ->badge()
                    ->color('warning')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('nilai.nilai_hasil')
                    ->label('Nilai Hasil')
                    ->badge()
                    ->color('success')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status Judul')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hasil'     => 'Ujian Hasil',
                        'proposal'  => 'Ujian Proposal',
                        'pengajuan' => 'Pengajuan',
                        default     => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'hasil'     => 'success',
                        'proposal'  => 'warning',
                        'pengajuan' => 'danger',
                        default     => 'gray',
                    })
                    ->summarize(Count::make())
                    ->toggleable(),
            ])
            ->emptyStateHeading('Belum ada data laporan')
            ->emptyStateDescription('Data laporan skripsi mahasiswa untuk prodi Anda akan muncul di sini.')
            ->emptyStateIcon('heroicon-o-document-chart-bar')
            ->filters([
                SelectFilter::make('tahun_akademik_id')
                    ->label('Tahun Akademik')
                    ->native(false)
                    ->searchable()
                    ->options(
                        TahunAkademik::query()
                            ->pluck(DB::raw("CONCAT('[',takad,'-', priode,']', '-',status)"), 'id')
                    ),

                SelectFilter::make('status')
                    ->label('Status Judul')
                    ->native(false)
                    ->options([
                        'pengajuan' => 'Pengajuan',
                        'proposal'  => 'Ujian Proposal',
                        'hasil'     => 'Ujian Hasil',
                    ]),
            ])
            ->headerActions([
                Action::make('export_xlsx')
                    ->label('Export XLSX')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($livewire) {
                        $user   = auth()->user();
                        $prodiId = $user?->prodi_id;

                        $filterTahun = $livewire->tableFilters['tahun_akademik_id']['value'] ?? null;

                        $tahunAkademikLabel = null;
                        $prodiLabel         = null;

                        // Label prodi dari user KPS yang login
                        $prodi = \App\Models\Prodi::find($prodiId);
                        if ($prodi) {
                            $prodiLabel = $prodi->nama_prodi;
                        }

                        $query = Judul::with([
                            'mahasiswa.prodi',
                            'tahunAkademik',
                            'nilai',
                            'suratKeputusan',
                            'pembimbingSatu',
                            'pembimbingDua',
                            'pengujiSatu',
                            'pengujiDua',
                        ])->whereHas('mahasiswa', fn ($q) => $q->where('prodi_id', $prodiId));

                        if ($filterTahun) {
                            $query->where('tahun_akademik_id', $filterTahun);
                            $ta = TahunAkademik::find($filterTahun);
                            if ($ta) {
                                $tahunAkademikLabel = "Tahun Akademik: [{$ta->takad}-{$ta->priode}]-{$ta->status}";
                            }
                        }

                        $data = $query->orderBy('tahun_akademik_id')->orderBy('status')->get();

                        $filename = 'laporan-kps-' . now()->format('Ymd-His') . '.xlsx';

                        return (new LaporanExport($data, $tahunAkademikLabel, $prodiLabel))->download($filename);
                    }),
            ])
            ->recordActions([]);
    }
}
