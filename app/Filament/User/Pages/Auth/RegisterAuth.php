<?php

namespace App\Filament\User\Pages\Auth;

use DiogoGPinto\AuthUIEnhancer\Pages\Auth\Concerns\HasCustomLayout;
use Filament\Auth\Pages\Register;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;

class RegisterAuth extends Register
{
    use HasCustomLayout;
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getUniqueIdFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label("Nama")
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getUniqueIdFormComponent(): Component
    {
        return TextInput::make('nrp/nidn/npm')
            ->label('NPM (Nomor Pokok Mahasiswa)')
            ->required()
            ->maxLength(25)
            ->minLength(5)
            ->minValue(0)
            ->unique($this->getUserModel())
            ->numeric()
            ->validationMessages([
                'unique' => 'NPM (Nomor Pokok Mahasiswa) Sudah Terdaftar',
            ]);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label("Email")
            ->email()
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel())
            ->validationMessages([
                'unique' => 'Email Sudah Sudah Terdaftar',
            ]);;
    }


    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('Kata Sandi'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(Password::default())
            ->showAllValidationMessages()
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::auth/pages/register.form.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('Konfirmasi Kata Sandi'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }

    public function getHeading(): string|Htmlable
    {
        return "Daftar Akun";
    }

    public function getSubheading(): string|Htmlable|null
    {
        return new HtmlString(__('Atau') . ' ' . '<a href="' . route('filament.user.auth.login') . '" class="font-medium text-primary-600 hover:text-primary-500">' . __('masuk ke akun Anda') . '</a>');
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.user.auth.login');
    }

}
