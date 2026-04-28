<?php

namespace App\Filament\Resources\UserAccounts\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor\TipTapExtensions\TextColorExtension;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserAccountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Nama')
                ->searchable(),
                TextColumn::make('nrp/nidn/npm')
                ->label('NRP / NIDN / NPM')
                ->searchable(),
                TextColumn::make('email')
                ->searchable(),
                TextColumn::make('role')
                    ->searchable()
                    ->formatStateUsing( function (string $state,  User $recored): string {
                         if ($recored->role === 'user') {
                             return 'mahasiswa';
                        } else {
                            return $state;
                        }
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('verifyEmail')
                    ->label('Verify')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->action(function (User $record) {
                        $record->markEmailAsVerified(); // Using Laravel's built-in method
                    })
                    ->visible(fn (User $record) => ! $record->hasVerifiedEmail())
                    ->requiresConfirmation()
                    ->tooltip('Verify Email'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
