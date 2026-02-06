<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class MyActiveOrders extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Mening faol buyurtmalarim';

    public function table(Table $table): Table
    {
        $portfolio = Auth::user()->translatorPortfolio;

        return $table
            ->query(
                Order::query()
                    ->where('translator_id', $portfolio?->id)
                    ->whereIn('status', ['accepted', 'in_progress'])
                    ->with(['user', 'work', 'language'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('№')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->size('sm')
                    ->weight('semibold')
                    ->prefix('#')
                    ->color('primary'),

                Tables\Columns\TextColumn::make('work.title')
                    ->label('Asar')
                    ->limit(40)
                    ->searchable()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 40) {
                            return $state;
                        }
                        return null;
                    })
                    ->weight('semibold')
                    ->icon('heroicon-m-book-open')
                    ->iconColor('primary')
                    ->size('sm')
                    ->wrap(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Mijoz')
                    ->searchable()
                    ->icon('heroicon-m-user')
                    ->iconColor('gray')
                    ->size('sm')
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('language.lang_name')
                    ->label('Tarjima tili')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-language'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Holat')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'accepted' => 'Qabul qilindi',
                        'in_progress' => 'Jarayonda',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'info',
                        'in_progress' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'accepted' => 'heroicon-m-check-circle',
                        'in_progress' => 'heroicon-m-arrow-path',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Muddat')
                    ->date('d.m.Y H:i')
                    ->sortable()
                    ->icon('heroicon-m-calendar-days')
                    ->iconColor(fn ($record) => $record->deadline->isPast() ? 'danger' : 'success')
                    ->size('sm')
                    ->weight('medium')
                    ->color(fn ($record) => $record->deadline->isPast() ? 'danger' : ($record->deadline->diffInDays() <= 3 ? 'warning' : 'success'))
                    ->description(fn ($record) => $record->deadline->isPast()
                        ? '⚠️ Muddati o\'tgan'
                        : ($record->deadline->diffInDays() <= 3
                            ? '⏰ ' . $record->deadline->diffForHumans()
                            : $record->deadline->diffForHumans()
                        )
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Boshlangan')
                    ->since()
                    ->sortable()
                    ->icon('heroicon-m-clock')
                    ->iconColor('gray')
                    ->size('sm')
                    ->tooltip(fn ($record) => $record->created_at->format('d.m.Y H:i')),
            ])
            ->defaultSort('deadline', 'asc')
            ->striped()
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(10)
            ->emptyStateHeading('Faol buyurtmalar yo\'q')
            ->emptyStateDescription('Hozirda sizda faol tarjima loyihalari mavjud emas.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list')
            ->emptyStateActions([
                Action::make('browse_orders')
                    ->label('Buyurtmalarni ko\'rish')
                    ->icon('heroicon-m-magnifying-glass')
                    ->color('primary')
                    ->url(fn (): string => route('filament.app.resources.orders.index')),
            ]);
    }

    public static function canView(): bool
    {
        return auth()->user()?->isTranslator() ?? false;
    }
}
