<?php

namespace App\Filament\User\Pages\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class Login extends \Filament\Auth\Pages\Login
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('Email Anda'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }


    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('Kata Sandi'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'filament-panels::auth/pages/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }


    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label(__('Ingat Saya'));
    }

    public function getHeading(): string|Htmlable
    {
        return 'Masuk';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return new HtmlString(__('Atau') . ' ' . '<a href="' . route('filament.user.auth.register') . '" class="font-medium text-primary-600 hover:text-primary-500">' . __('Buat Akun Anda') . '</a>');
    }


    protected function getFooter(): ?Htmlable
    {
        return new HtmlString(
            '<p class="text-center text-xs text-gray-500 dark:text-gray-400">© ' . date('Y') . ' Undangan-Apps. All rights reserved.</p>'
        );
    }

}

