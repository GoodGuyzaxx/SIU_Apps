<?php

namespace App\Filament\User\Pages\Auth;

use Filament\Actions\Action;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class Login extends \Filament\Auth\Pages\Login
{

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
                $this->getButton()
            ]);

    }

    protected function getButton(): Action{
        return Action::make('Admin')
            ->link()
            ->label("Login Sebagai Admin")
            ->url( fn () => url('admin/login'));
    }
}
