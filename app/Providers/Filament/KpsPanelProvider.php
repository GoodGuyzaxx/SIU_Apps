<?php

namespace App\Providers\Filament;

use App\Filament\Kps\Widgets\KpsDashboardWidget;
use App\Filament\Kps\Widgets\ProdiStats;
use App\Http\Middleware\OnlyKps;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class KpsPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('kps')
            ->path('kps')
            ->databaseNotifications()
            ->databaseNotificationsPolling('15s')
            ->globalSearch(false)
            ->viteTheme('resources/css/filament/kps/theme.css')
            ->login(fn() => redirect()->route("filament.user.auth.login"))
            ->brandLogo( fn() => view('filament.logo'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Kps/Resources'), for: 'App\Filament\Kps\Resources')
            ->discoverPages(in: app_path('Filament/Kps/Pages'), for: 'App\Filament\Kps\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Kps/Widgets'), for: 'App\Filament\Kps\Widgets')
            ->widgets([
                KpsDashboardWidget::class,
                ProdiStats::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                OnlyKps::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn () => view('costumeFooter'),
            );
    }
}
