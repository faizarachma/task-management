<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Resources\ProfileResource;
use App\Filament\Admin\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Inter')
            ->brandName('Admin Panel')
            ->favicon(asset('images/favicon.ico'))
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->navigationItems([
                NavigationItem::make('Profile')
                    ->url(fn (): string => ProfileResource::getUrl('edit', ['record' => auth()->id()]))
                    ->icon('heroicon-o-user-circle')
                    ->group('Account')
                    ->sort(1)
                    ->visible(fn (): bool => auth()->check()),
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                \App\Http\Middleware\ValidateAdminAccount::class,
                \App\Http\Middleware\CheckRole::class.':admin',
            ])
            // ->databaseNotifications()
            ->passwordReset()
            ->emailVerification();
    }

    public function boot(): void
    {
        $this->app['events']->listen(\Illuminate\Auth\Events\Failed::class, function ($event) {
            return redirect('/') // Redirect to root
                ->withInput()
                ->withErrors([
                    'email' => 'Email atau password salah.',
                    'password' => 'Email atau password salah.',
                ]);
        });
    }
}
