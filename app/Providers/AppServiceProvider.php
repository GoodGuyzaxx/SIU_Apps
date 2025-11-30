<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use App\Models\StatusUndangan;
use App\Observers\StatusUndangaObserver;
use Carbon\Carbon;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        StatusUndangan::observe(StatusUndangaObserver::class);
        Carbon::setLocale("id");
        \Livewire\Livewire::forceAssetInjection();
//        if (
//            env("APP_ENV") !== "local" ||
//            str_contains(request()->getHost(), ".ngrok.io") ||
//            str_contains(request()->getHost(), ".ngrok-free.app")
//        ) {
//            // Check for ngrok domain
//            URL::forceScheme("https");
//        }
    }
}
