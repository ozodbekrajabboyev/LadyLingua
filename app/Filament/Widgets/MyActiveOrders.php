<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class MyActiveOrders extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

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
                    ->label('Order #')
                    ->sortable(),

                Tables\Columns\TextColumn::make('work.title')
                    ->label('Work')
                    ->limit(40)
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable(),

                Tables\Columns\TextColumn::make('language.lang_name')
                    ->label('Target Language')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'accepted' => 'info',
                        'in_progress' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->color(fn ($record) => $record->deadline->isPast() ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Started')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('deadline', 'asc')
            ->emptyStateHeading('No active orders')
            ->emptyStateDescription('You don\'t have any active translation projects right now.')
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
    }

    public static function canView(): bool
    {
        return auth()->user()->isTranslator();
    }
}
