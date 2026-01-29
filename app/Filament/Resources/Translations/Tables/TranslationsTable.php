<?php

namespace App\Filament\Resources\Translations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
//use Filament\Tables\Actions\BulkActionGroup;
//use Filament\Tables\Actions\DeleteBulkAction;
//use Filament\Tables\Actions\EditAction;
//use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\AvailableLanguage;
use App\Models\Work;

class TranslationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('work.title')
                    ->label('Work Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    }),

                TextColumn::make('language.lang_name')
                    ->label('Target Language')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'danger' => 'blocked',
                    ])
                    ->icons([
                        'heroicon-o-pencil' => 'draft',
                        'heroicon-o-check-circle' => 'published',
                        'heroicon-o-x-circle' => 'blocked',
                    ])
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('preview_pages_cnt')
                    ->label('Preview Pages')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->suffix(' pages'),

                TextColumn::make('upload.file_path')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? '📄 Uploaded' : 'No file')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->since()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'blocked' => 'Blocked',
                    ])
                    ->multiple(),

                SelectFilter::make('language_id')
                    ->label('Language')
                    ->options(AvailableLanguage::all()->pluck('lang_name', 'id'))
                    ->searchable()
                    ->multiple(),

                SelectFilter::make('work_id')
                    ->label('Work')
                    ->options(Work::all()->pluck('title', 'id'))
                    ->searchable()
                    ->multiple(),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
