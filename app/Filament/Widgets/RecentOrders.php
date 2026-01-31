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
                    ->label('Order #')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('work.title')
                    ->label('Work')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('translator.user.name')
                    ->label('Translator')
                    ->searchable(),

                Tables\Columns\TextColumn::make('language.lang_name')
                    ->label('Language')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'accepted' => 'info',
                        'in_progress' => 'warning',
                        'completed' => 'success',
                        'rejected' => 'danger',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime('M d, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ordered')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
}
