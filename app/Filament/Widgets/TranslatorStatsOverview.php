<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Translation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TranslatorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $portfolio = Auth::user()->translatorPortfolio;

        if (!$portfolio) {
            return [];
        }

        $earnings = Translation::where('translator_id', $portfolio->id)->sum('price');
        $completed = Translation::where('translator_id', $portfolio->id)
            ->where('status', 'published')
            ->count();
        $activeOrders = Order::where('translator_id', $portfolio->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->count();

        return [
            Stat::make('Total Earnings', 'UZS ' . number_format($earnings, 2))
                ->description('Your lifetime earnings')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([50, 100, 150, 200, 300, 400, $earnings]),

            Stat::make('Average Rating', number_format($portfolio->average_rating, 1) . ' ⭐')
                ->description('Your customer rating')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->chart([3.5, 3.8, 4.0, 4.2, 4.3, 4.5, $portfolio->average_rating]),

            Stat::make('Completed Works', $completed)
                ->description('Total translations done')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info')
                ->chart([2, 5, 8, 12, 15, 20, $completed]),

            Stat::make('Active Projects', $activeOrders)
                ->description('Current assignments')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning')
                ->chart([1, 2, 3, 2, 3, 4, $activeOrders]),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isTranslator();
    }
}
