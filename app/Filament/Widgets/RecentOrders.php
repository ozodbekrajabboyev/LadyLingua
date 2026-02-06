<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrders extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'So\'nggi buyurtmalar';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->with(['user', 'translator.user', 'work', 'language'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('№')
                    ->sortable()
                    ->searchable()
                    ->alignCenter()
                    ->size('sm')
                    ->weight('semibold')
                    ->prefix('#'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Mijoz')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->iconColor('gray')
                    ->size('sm')
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('work.title')
                    ->label('Asar')
                    ->limit(30)
                    ->searchable()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 30) {
                            return $state;
                        }
                        return null;
                    })
                    ->icon('heroicon-m-book-open')
                    ->iconColor('primary')
                    ->size('sm')
                    ->wrap(),

                Tables\Columns\TextColumn::make('translator.user.name')
                    ->label('Tarjimon')
                    ->searchable()
                    ->placeholder('Tayinlanmagan')
                    ->icon('heroicon-m-language')
                    ->iconColor('info')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('language.lang_name')
                    ->label('Til')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-m-globe-alt'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Holat')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Kutilmoqda',
                        'accepted' => 'Qabul qilindi',
                        'in_progress' => 'Jarayonda',
                        'completed' => 'Tugatildi',
                        'rejected' => 'Rad etildi',
                        'cancelled' => 'Bekor qilindi',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'accepted' => 'info',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        'rejected' => 'danger',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'accepted' => 'heroicon-m-check-circle',
                        'in_progress' => 'heroicon-m-arrow-path',
                        'completed' => 'heroicon-m-check-badge',
                        'rejected' => 'heroicon-m-x-circle',
                        'cancelled' => 'heroicon-m-no-symbol',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Muddat')
                    ->date('d.m.Y')
                    ->sortable()
                    ->icon('heroicon-m-calendar-days')
                    ->iconColor('warning')
                    ->size('sm')
                    ->color(fn ($record) => $record->deadline < now() ? 'danger' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Buyurtma sanasi')
                    ->since()
                    ->sortable()
                    ->icon('heroicon-m-clock')
                    ->iconColor('gray')
                    ->size('sm')
                    ->tooltip(fn ($record) => $record->created_at->format('d.m.Y H:i')),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(10)
            ->emptyStateHeading('Buyurtmalar yo\'q')
            ->emptyStateDescription('Hozircha hech qanday buyurtma mavjud emas')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }

    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}
