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
        $totalTranslators = TranslatorPortfolio::count();
        $totalWorks = Work::count();
        $activeOrders = Order::whereIn('status', ['pending', 'accepted', 'in_progress'])->count();
        $totalRevenue = Translation::sum('price');

        return [
            Stat::make('Tarjimonlar', $totalTranslators)
                ->description('Tizimda faol tarjimonlar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success')
                ->icon('heroicon-o-users')
                ->chart([7, 12, 15, 18, 22, 25, $totalTranslators])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Asarlar', $totalWorks)
                ->description('Mavjud adabiy asarlar')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('info')
                ->icon('heroicon-o-book-open')
                ->chart([3, 5, 8, 12, 15, 18, $totalWorks])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Faol buyurtmalar', $activeOrders)
                ->description('Jarayondagi buyurtmalar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->icon('heroicon-o-shopping-cart')
                ->chart([5, 8, 6, 10, 12, 8, $activeOrders])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Umumiy daromad', number_format($totalRevenue, 0, ',', ' ') . ' so\'m')
                ->description('Barcha tarjimalardan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->icon('heroicon-o-currency-dollar')
                ->chart([100000, 250000, 400000, 550000, 700000, 900000, $totalRevenue])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 2; // 2 columns on larger screens, will stack on mobile
    }

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
