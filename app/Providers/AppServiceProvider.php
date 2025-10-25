<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Carbon::setLocale("id");
        if (
            env("APP_ENV") !== "local" ||
            str_contains(request()->getHost(), ".ngrok.io") ||
            str_contains(request()->getHost(), ".ngrok-free.app")
        ) {
            // Check for ngrok domain
            URL::forceScheme("https");
        }
        \Livewire\Livewire::forceAssetInjection();
    }
}
