<?php

namespace App\Filament\Resources\Nilais\Tables;

use App\Models\Prodi;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NilaisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->rowIndex()
                    ->label('No.'),
                TextColumn::make('judul.mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('judul.mahasiswa.npm')
                    ->label('NPM')
                    ->searchable()
                    ->sortable(),

                ColumnGroup::make('Ujian Proposal', [
                    TextColumn::make('nilai_proposal')
                        ->label('Nilai Huruf')
                        ->placeholder('Belum Di isi')
                        ->badge()
                        ->searchable(),
                    TextColumn::make('tanggal_ujian_proposal')
                        ->label('Tanggal Ujian')
                        ->date('d/m/Y')
                        ->placeholder('Belum Di isi')
                        ->searchable(),
                ]),

                ColumnGroup::make('Ujian Hasil', [
                    TextColumn::make('nilai_hasil')
                        ->label('Nilai Huruf')
                        ->placeholder('Belum Di isi')
                        ->badge()
                        ->searchable(),
                    TextColumn::make('tanggal_ujian_hasil')
                        ->label('Tanggal Ujian')
                        ->placeholder('Belum Di Isi')
                        ->date('d/m/Y')
                        ->searchable(),
                ]),
            ])
            ->filters([
                SelectFilter::make('prodi_id')
                    ->label('Program Studi')
                    ->native(false)
                    ->options(Prodi::query()->pluck('nama_prodi', 'id'))
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        return $query->whereHas('judul.mahasiswa', function (Builder $q) use ($data) {
                            $q->where('prodi_id', $data['value']);
                        });
                    }),
                SelectFilter::make('nilai_proposal')
                    ->label('Nilai Proposal')
                    ->options([
                        'A' => 'A',
                        'AB' => 'AB',
                        'B' => 'B',
                        'BC' => 'BC',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'E',
                    ]),
                SelectFilter::make('nilai_hasil')
                    ->label('Nilai Hasil')
                    ->options([
                        'A' => 'A',
                        'AB' => 'AB',
                        'B' => 'B',
                        'BC' => 'BC',
                        'C' => 'C',
                        'D' => 'D',
                        'E' => 'E',
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Input Nilai')
                    ->label('Input Nilai')
                    ->slideOver(),
            ]);
    }
}
