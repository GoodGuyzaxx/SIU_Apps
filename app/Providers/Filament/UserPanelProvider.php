<?php

namespace App\Providers\Filament;

use App\Filament\User\Pages\Auth\Login;
use App\Filament\User\Pages\Auth\RegisterAuth;
use App\Filament\User\Pages\Profile\Pages\UserForm;
use App\Http\Middleware\RedirectPanel;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use DiogoGPinto\AuthUIEnhancer\Pages\Auth\EmailVerification\AuthUiEnhancerEmailVerificationPrompt;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('user')
            ->login(Login::class)
            ->registration(RegisterAuth::class)
            ->passwordReset()
            ->emailVerification()
            ->brandLogo( fn() => view('filament.logo'))
            ->viteTheme('resources/css/filament/user/theme.css')
            ->colors([
                'primary' => Color::Red,
            ])
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\Filament\User\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\Filament\User\Pages')
            ->pages([
                Dashboard::class,
                UserForm::class
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\Filament\User\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
                RedirectPanel::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                AuthUIEnhancerPlugin::make()
                    ->mobileFormPanelPosition('bottom')
                    ->formPanelWidth('40%')
                    ->formPanelPosition('left')
                    ->emptyPanelBackgroundImageUrl(asset('images/bg.jpg'))
                    ->showEmptyPanelOnMobile(false)
            ])
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn () => view('costumeFooter'),
            );
    }
}
