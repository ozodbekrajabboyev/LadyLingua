<?php

namespace App\Filament\Resources\Orders\Tables;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('work.title')
                    ->label('Asar nomi')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->copyMessage('Nomi nusxalandi')
                    ->wrap(),

                TextColumn::make('user.name')
                    ->label('Mijoz')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->iconColor('primary'),

                TextColumn::make('language.lang_name')
                    ->label('Target til')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-language'),

                TextColumn::make('status')
                    ->label('Holat')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'accepted' => 'info',
                        'rejected' => 'danger',
                        'in_progress' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Kutilmoqda',
                        'accepted' => 'Qabul qilindi',
                        'rejected' => 'Rad etildi',
                        'in_progress' => 'Jarayonda',
                        'completed' => 'Yakunlandi',
                        'cancelled' => 'Bekor qilindi',
                        default => $state,
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'accepted' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                        'in_progress' => 'heroicon-o-arrow-path',
                        'completed' => 'heroicon-o-check-badge',
                        'cancelled' => 'heroicon-o-no-symbol',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Yaratilgan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable()
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->label('Yangilangan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Holat')
                    ->options([
                        'pending' => 'Kutilmoqda',
                        'accepted' => 'Qabul qilindi',
                        'rejected' => 'Rad etildi',
                        'in_progress' => 'Jarayonda',
                        'completed' => 'Yakunlandi',
                        'cancelled' => 'Bekor qilindi',
                    ])
                    ->native(false),

                SelectFilter::make('language_id')
                    ->label('Til')
                    ->relationship('language', 'lang_name')
                    ->searchable()
                    ->preload()
                    ->native(false),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Dan'),
                        DatePicker::make('created_until')
                            ->label('Gacha'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Dan: ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Gacha: ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }
                        return $indicators;
                    }),
            ])
            ->filtersFormColumns(3)
            ->recordActions([
                ViewAction::make()
                    ->iconButton()
                    ->color('info'),
                Action::make('changeStatus')
                    ->label('Holatni o\'zgartirish')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->iconButton()
                    ->tooltip('Holatni o\'zgartirish')
                    ->visible(fn (): bool => auth()->user()->role === 'translator')
                    ->form([
                        Select::make('status')
                            ->label('Yangi holat')
                            ->options([
                                'pending' => 'Kutilmoqda',
                                'accepted' => 'Qabul qilindi',
                                'rejected' => 'Rad etildi',
                                'in_progress' => 'Jarayonda',
                                'completed' => 'Yakunlandi',
                                'cancelled' => 'Bekor qilindi',
                            ])
                            ->required()
                            ->native(false)
                            ->default(fn ($record) => $record->status),

                        Textarea::make('notes')
                            ->label('Izoh (ixtiyoriy)')
                            ->rows(3)
                            ->placeholder('Holat o\'zgarishi uchun izoh qoldiring...'),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                        ]);

                        // Optional: Save notes if you have a notes field or history table
                        // $record->notes()->create(['note' => $data['notes']]);

                        Notification::make()
                            ->title('Holat muvaffaqiyatli yangilandi')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Buyurtma holatini o\'zgartirish')
                    ->modalDescription('Buyurtma holatini tanlang va kerakli izoh qoldiring.')
                    ->modalSubmitActionLabel('Saqlash')
                    ->modalCancelActionLabel('Bekor qilish')
                    ->modalWidth('md'),
            ])
            ->emptyStateHeading('Hech qanday tarjima topilmadi')
            ->emptyStateDescription('Yangi tarjima qo\'shish uchun yuqoridagi tugmani bosing.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }
}
