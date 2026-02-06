<?php

namespace App\Filament\Resources\Works\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WorksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Nomi')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->size('sm')
                    ->icon('heroicon-m-book-open')
                    ->iconColor('primary')
                    ->wrap()
                    ->description(fn ($record) => $record->description ? \Str::limit($record->description, 60) : null)
                    ->color('primary'),

                TextColumn::make('author_name')
                    ->label('Muallif')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('gray')
                    ->size('sm')
                    ->weight('medium'),

                TextColumn::make('originalLanguage.lang_name')
                    ->label('Asl tili')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-language'),

                TextColumn::make('translations_count')
                    ->label('Tarjimalar')
                    ->counts('translations')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state === 0 => 'gray',
                        $state < 3 => 'warning',
                        $state < 5 => 'success',
                        default => 'primary',
                    })
                    ->icon('heroicon-m-language')
                    ->alignCenter()
                    ->sortable()
                    ->suffix(fn ($state) => $state === 1 ? ' ta' : ' ta'),

                TextColumn::make('created_at')
                    ->label('Qo\'shilgan sana')
                    ->date('d.m.Y')
                    ->sortable()
                    ->icon('heroicon-m-calendar')
                    ->iconColor('gray')
                    ->size('sm')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Oxirgi yangilanish')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->icon('heroicon-m-clock')
                    ->iconColor('gray')
                    ->size('sm')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('original_language_id')
                    ->label('Asl tili')
                    ->relationship('originalLanguage', 'lang_name')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->placeholder('Tilni tanlang'),

                Filter::make('has_translations')
                    ->label('Tarjimasi bor')
                    ->query(fn (Builder $query): Builder => $query->has('translations'))
                    ->toggle(),

                Filter::make('no_translations')
                    ->label('Tarjimasi yo\'q')
                    ->query(fn (Builder $query): Builder => $query->doesntHave('translations'))
                    ->toggle(),

                Filter::make('created_this_month')
                    ->label('Shu oy qo\'shilganlar')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->startOfMonth()))
                    ->toggle(),
            ])
            ->actions([
                EditAction::make()
                    ->label('')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning'),
//                DeleteAction::make()
//                    ->label('O\'chirish')
//                    ->requiresConfirmation()
//                    ->icon('heroicon-m-trash')
//                    ->color('danger'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Tanlanganlarni o\'chirish')
                        ->requiresConfirmation()
                        ->modalHeading('Asarlarni o\'chirish')
                        ->modalDescription('Tanlangan asarlarni o\'chirishga ishonchingiz komilmi? Bu amalni bekor qilib bo\'lmaydi.')
                        ->modalSubmitActionLabel('Ha, o\'chirish')
                        ->modalCancelActionLabel('Bekor qilish'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->poll('30s')
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistSortInSession()
            ->emptyStateHeading('Hozircha asarlar yo\'q')
            ->emptyStateDescription('Birinchi adabiy asaringizni qo\'shishdan boshlang.')
            ->emptyStateIcon('heroicon-o-book-open')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Yangi asar qo\'shish')
                    ->icon('heroicon-m-plus')
                    ->color('primary'),
            ]);
    }
}
