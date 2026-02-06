<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Rating;
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
            return [
                Stat::make('Portfolio topilmadi', 'Iltimos, profilingizni to\'ldiring')
                    ->description('Tarjimon portfelingizni yarating')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('warning')
                    ->icon('heroicon-o-user-circle'),
            ];
        }

        // Calculate average rating safely from translations' ratings
        $averageRating = $this->calculateAverageRating($portfolio);

        // Get recent rating trend for the chart (last 7 ratings)
        $ratingTrend = $this->getRatingTrend($portfolio);

        $earnings = Translation::where('translator_id', $portfolio->id)->sum('price');
        $completed = Translation::where('translator_id', $portfolio->id)
            ->where('status', 'published')
            ->count();
        $activeOrders = Order::where('translator_id', $portfolio->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->count();
        $pendingOrders = Order::where('translator_id', $portfolio->id)
            ->where('status', 'pending')
            ->count();

        return [
            Stat::make('Umumiy daromad', number_format($earnings, 0, ',', ' ') . ' so\'m')
                ->description('Barcha ishlaringizdan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->icon('heroicon-o-currency-dollar')
                ->chart([50000, 100000, 150000, 200000, 300000, 400000, $earnings])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Reyting', number_format($averageRating, 1) . ' ⭐')
                ->description('Mijozlar bahosi')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning')
                ->icon('heroicon-o-star')
                // Use the real trend data, or fall back to a flat line if no ratings exist
                ->chart(count($ratingTrend) > 1 ? $ratingTrend : [$averageRating > 0 ? $averageRating : 0, $averageRating > 0 ? $averageRating : 0])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Bajarilgan ishlar', $completed)
                ->description('Jami tarjimalar soni')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-o-check-badge')
                ->chart([2, 5, 8, 12, 15, 20, $completed])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:shadow-lg transition',
                ]),

            Stat::make('Faol loyihalar', $activeOrders)
                ->description($pendingOrders > 0 ? $pendingOrders . ' ta yangi taklif' : 'Joriy topshiriqlar')
                ->descriptionIcon($pendingOrders > 0 ? 'heroicon-m-bell-alert' : 'heroicon-m-clipboard-document-list')
                ->color($pendingOrders > 0 ? 'danger' : 'info')
                ->icon('heroicon-o-briefcase')
                ->chart([1, 2, 3, 2, 3, 4, $activeOrders])
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
        return auth()->user()?->isTranslator() ?? false;
    }

    /**
     * Calculate average rating safely for the translator
     */
    private function calculateAverageRating($portfolio): float
    {
        try {
            // Get all ratings for translations by this translator
            $averageRating = $portfolio->ratings()
                ->selectRaw('AVG(ratings.stars) as avg_rating')
                ->value('avg_rating');

            return (float) ($averageRating ?? 0.0);
        } catch (\Exception $e) {
            // Fallback: calculate from the stored average_rating column
            return (float) ($portfolio->average_rating ?? 0.0);
        }
    }

    /**
     * Get rating trend data for chart display
     */
    private function getRatingTrend($portfolio): array
    {
        try {
            return $portfolio->ratings()
                ->orderBy('ratings.created_at', 'desc')
                ->limit(7)
                ->pluck('stars')
                ->reverse() // Show oldest to newest in the chart
                ->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }
}
