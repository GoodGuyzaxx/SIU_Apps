<?php

namespace App\Filament\Resources\Laporans\Tables;

use App\Exports\LaporanExport;
use App\Models\Judul;
use App\Models\TahunAkademik;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\Summarizers\Count;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LaporansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mahasiswa.npm')
                    ->label('NPM')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('judul')
                    ->label('Judul Skripsi')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('tahunAkademik.takad')
                    ->label('Tahun Akademik'),
                TextColumn::make('suratkeputusan')
                    ->label('No. SK')
                    ->formatStateUsing(fn($record) => $record->suratKeputusan->nomor_sk_pembimbing . ' / ' . $record->suratKeputusan->nomor_sk_penguji)
                    ->placeholder('Belum ada'),
                TextColumn::make('nilai')
                    ->label('Nilai Proposal / Hasil')
                    ->formatStateUsing(fn($record) =>
                        ($record->nilai->nilai_proposal ?? 'Belum ada') . ' / ' . ($record->nilai->nilai_hasil ?? 'Belum ada')
                    )
                    ->placeholder('Belum dinilai'),
                TextColumn::make('status')
                    ->label('Status Judul')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hasil'    => 'success',  // Hijau
                        'proposal' => 'warning',  // Kuning/Oranye
                        'pengajuan' => 'danger',   // Merah
                        default    => 'gray',     // Warna default jika tidak cocok
                    })
                ->summarize(Count::make())
            ])
            ->filters([
                SelectFilter::make('tahun_akademik_id')
                    ->label('Tahun Akademik')
                    ->native(false)
                    ->searchable()
                    ->options(
                        TahunAkademik::query()
                            ->pluck(DB::raw("CONCAT('[',takad,'-', priode,']', '-',status)"), 'id')
                    )
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->headerActions([
                Action::make('export_xlsx')
                    ->label('Export XLSX')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($livewire) {
                        // Ambil filter tahun akademik yang sedang aktif
                        $filterState       = $livewire->tableFilters['tahun_akademik_id']['value'] ?? null;
                        $tahunAkademikLabel = null;

                        $query = Judul::with(['mahasiswa', 'tahunAkademik', 'nilai', 'suratKeputusan']);

                        if ($filterState) {
                            $query->where('tahun_akademik_id', $filterState);
                            $ta = TahunAkademik::find($filterState);
                            if ($ta) {
                                $tahunAkademikLabel = "Tahun Akademik: [{$ta->takad}-{$ta->priode}]-{$ta->status}";
                            }
                        }

                        $data = $query->orderBy('tahun_akademik_id')
                            ->orderBy('status')
                            ->get();

                        $filename = 'laporan-skripsi-' . now()->format('Ymd-His') . '.xlsx';

                        return (new LaporanExport($data, $tahunAkademikLabel))->download($filename);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('Migrasi')
                        ->color('success')
                        ->icon('heroicon-s-arrow-path')
                        ->requiresConfirmation()
                        ->modalHeading('Migrasi Data Judul')
                        ->modalSubheading('Apakah Anda yakin ingin memigrasikan data yang dipilih ke tahun akademik aktif?')
                        ->modalButton('Ya, Migrasikan')
                        ->action(function (Collection $records): void {
                            $takad = TahunAkademik::where('status', 'Y')->first();
                            if ($takad) {
                                $records->each->update(['tahun_akademik_id' => $takad->id]);
                            }
                        })
                ]),
            ]);
    }
}
