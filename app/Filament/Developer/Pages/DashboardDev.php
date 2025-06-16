<?php


namespace App\Filament\Developer\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class DashboardDev extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Developer Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';

s
    protected static string $view = 'dashboarddev';
}
