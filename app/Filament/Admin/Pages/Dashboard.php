<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $routePath = 'dashboard';

    // Updated method to match parent signature
    public static function getRouteName(?string $panel = null): string
    {
        return 'filament.admin.pages.dashboard';
    }
}
