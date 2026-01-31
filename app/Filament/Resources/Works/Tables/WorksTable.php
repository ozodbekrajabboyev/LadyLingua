<?php

namespace App\Filament\Resources\Works\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WorksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-book-open')
                    ->iconColor('primary'),

                TextColumn::make('author_name')
                    ->label('Author')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->placeholder('No description')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('originalLanguage.lang_name')
                    ->label('Original Language')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('translations_count')
                    ->label('Translations')
                    ->counts('translations')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Added')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('original_language_id')
                    ->label('Original Language')
                    ->relationship('originalLanguage', 'lang_name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Filter::make('has_translations')
                    ->label('Has Translations')
                    ->query(fn (Builder $query): Builder => $query->has('translations')),

                Filter::make('no_translations')
                    ->label('No Translations')
                    ->query(fn (Builder $query): Builder => $query->doesntHave('translations')),

                Filter::make('created_this_month')
                    ->label('Added This Month')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->startOfMonth())),
            ])
//            ->actions([
//                ViewAction::make(),
//                EditAction::make(),
//                DeleteAction::make()
//                    ->requiresConfirmation(),
//            ])
            ->bulkActions([
//                BulkActionGroup::make([
//                    DeleteBulkAction::make()
//                        ->requiresConfirmation(),
//                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('No works yet')
            ->emptyStateDescription('Start by adding your first literary work.')
            ->emptyStateIcon('heroicon-o-book-open');
    }
}
