<?php

namespace App\Filament\Resources\Juduls\Tables;

use App\Models\Judul;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JudulsTable
{
    public static function configure(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('mahasiswa.nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('judul')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('pembimbingSatu.nama')
                    ->searchable(),
                TextColumn::make('pembimbingDua.nama')
                    ->searchable(),
                SelectColumn::make('status')
                    ->native(false)
                    ->sortable()
                    ->options([
                        'pengajuan' => 'Pengajuan',
                        'proposal' => 'Proposal',
                        'hasil' => 'Hasil'
                    ]),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                ->label('Status Judul')
                ->options([
                    'pengajuan' => 'Pengajuan',
                    'proposal' => 'Proposal',
                    'hasil' => 'Hasil'
                ])
            ])
            ->recordActions([
                Action::make('nilai')
                ->label('Input Nilai')
                ->color('success')
                ->icon('heroicon-s-pencil')
                ->fillForm(fn (Judul $record): array => $record->nilai?->toArray() ?? [])
                ->schema([
                    Grid::make(2)
                    ->schema([
                        TextInput::make('nilai_proposal')
                            ->label('Nilai Proposal'),
                        DatePicker::make('tanggal_ujian_proposal')
                            ->label('Tanggal Ujian Proposal')
                            ->date()
                            ->native(false)
                            ->suffixAction(
                                Action::make('clear')
                                    ->icon('heroicon-m-x-mark')
                                    ->action(fn (Set $set) => $set('tanggal_ujian_proposal', null))
                            )
                            ->native(false),
                        TextInput::make('nilai_hasil')
                            ->label('Nilai Hasil'),
                        DatePicker::make('tanggal_ujian_hasil')
                            ->label('Tanggal Ujian Hasil')
                            ->date()
                            ->suffixAction(
                                Action::make('clear')
                                    ->icon('heroicon-m-x-mark')
                                    ->action(fn (Set $set) => $set('tanggal_ujian_hasil', null))
                            )

                            ->native(false),
                    ]),
                ])
                ->action(function (array $data, Judul $record): void {
                    $record->nilai()->update($data);
                    Notification::make()
                        ->title('Nilai Berhasil Di input')
                        ->success()
                        ->send();
                }),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
