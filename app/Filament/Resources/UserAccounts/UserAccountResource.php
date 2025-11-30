<?php

namespace App\Filament\Resources\UserAccounts;

use App\Filament\Resources\UserAccounts\Pages\CreateUserAccount;
use App\Filament\Resources\UserAccounts\Pages\EditUserAccount;
use App\Filament\Resources\UserAccounts\Pages\ListUserAccounts;
use App\Filament\Resources\UserAccounts\Schemas\UserAccountForm;
use App\Filament\Resources\UserAccounts\Tables\UserAccountsTable;
use App\Models\User;
use App\Models\UserAccount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserAccountResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 15;

    protected static ?string $breadcrumb = "Akun";

    protected static string | UnitEnum | null $navigationGroup = 'Data Master';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-s-user';

    protected static ?string $navigationLabel = 'Akun Pengguna';

    public static function canAccess(): bool
    {
        if (auth()->user()->role === 'admin'){
            return true;
        }
        return false;
    }


    public static function form(Schema $schema): Schema
    {
        return UserAccountForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserAccountsTable::configure($table);
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
            'index' => ListUserAccounts::route('/'),
            'create' => CreateUserAccount::route('/create'),
            'edit' => EditUserAccount::route('/{record}/edit'),
        ];
    }
}
