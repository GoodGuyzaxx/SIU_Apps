<?php

namespace App\Filament\Resources\UserAccounts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('nrp/nidn/npm')
                    ->required()
                    ->unique(),
                TextInput::make('email')
                ->unique()
                ->required(),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Select::make('role')
                ->options([
                    'dekan' => 'Dekan',
                    'kaprodi' => 'Kepala Program Studi',
                    'akademik' => 'Akademik',
                    'dosen' => 'Dosen',
                    'user' => 'Mahasiswa',
                ])
            ]);
    }
}
