<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\EarningsPerProductWidget;
use App\Filament\Widgets\PaymentMethodsWidget;
use App\Filament\Widgets\Purchases\PurchasesPerProductPerDayWidget;
use App\Filament\Widgets\Purchases\PurchasesPerPurchasablePerDayWidget;
use App\Filament\Widgets\PurchasesPerProductWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Http\Controllers\Admin\GoogleAdminLoginController;
use App\Http\Middleware\EnsureAdminPanelAccess;
use Filament\Facades\Filament;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Enums\Width;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Livewire\Livewire;

class AdminPanelProvider extends PanelProvider
{
    public function boot(): void
    {
        Filament::serving(function (): void {
            Livewire::forceAssetInjection();
        });
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->maxContentWidth(Width::Full)
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('web')
            ->login(GoogleAdminLoginController::class)
            ->routes(function (): void {
                Route::post('login/google', [GoogleAdminLoginController::class, 'redirect'])
                    ->middleware('throttle:10,1')->name('auth.google');
                Route::get('auth/google/callback', [GoogleAdminLoginController::class, 'callback'])
                    ->middleware('throttle:10,1')->name('auth.google.callback');
            })
            ->colors([
                'primary' => '#197593',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                StatsOverviewWidget::class,
                PurchasesPerProductWidget::class,
                EarningsPerProductWidget::class,
                PaymentMethodsWidget::class,
                PurchasesPerProductPerDayWidget::class,
                PurchasesPerPurchasablePerDayWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                EnsureAdminPanelAccess::class,
            ], isPersistent: true)->navigationGroups([
                'Customers',
                'Products',
                'Courses',
                'Content',
                'Team',
            ]);
    }
}
