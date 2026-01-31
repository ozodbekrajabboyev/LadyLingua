<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Translation;
use App\Models\TranslatorPortfolio;
use App\Models\Work;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Translators', TranslatorPortfolio::count())
                ->description('Active translators in system')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, 30]),

            Stat::make('Total Works', Work::count())
                ->description('Literary works available')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('info')
                ->chart([3, 5, 8, 12, 15, 18, 20]),

            Stat::make('Active Orders', Order::whereIn('status', ['pending', 'accepted', 'in_progress'])->count())
                ->description('Orders in progress')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning')
                ->chart([5, 8, 6, 10, 12, 8, 9]),

            Stat::make('Total Revenue', 'UZS ' . number_format(Translation::sum('price'), 2))
                ->description('From all translations')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([100, 250, 400, 550, 700, 900, 1200]),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
}
