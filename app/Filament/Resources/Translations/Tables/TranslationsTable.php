<?php

namespace App\Filament\Resources\Translations\Tables;

use Carbon\Carbon;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
//use Filament\Tables\Actions\EditAction;
//use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TranslationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                // If translator, show only their own translations
                if ($user->isTranslator()) {
                    $translatorPortfolio = $user->translatorPortfolio;
                    if ($translatorPortfolio) {
                        $query->where('translator_id', $translatorPortfolio->id);
                    } else {
                        // If translator has no portfolio, show nothing
                        $query->whereRaw('1 = 0');
                    }
                }

                // Admins see everything (no filter applied)

                return $query;
            })
            ->columns([
                TextColumn::make('work.title')
                    ->label('Asar nomi')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->wrap(),

                TextColumn::make('translator.user.name')
                    ->label('Tarjimon')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->visible(fn () => auth()->user()->isAdmin()), // Only admins see this

                TextColumn::make('language.lang_name')
                    ->label('Tarjima tili')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('status')
                    ->label('Holati')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'warning',
                        'published' => 'success',
                        'blocked' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Qoralama',
                        'published' => 'Nashr etilgan',
                        'blocked' => 'Bloklangan',
                        default => $state,
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'draft' => 'heroicon-o-pencil',
                        'published' => 'heroicon-o-check-circle',
                        'blocked' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Narxi')
                    ->money('UZS')
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(),

                TextColumn::make('preview_pages_cnt')
                    ->label('Ko\'rib chiqish sahifalari')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->suffix(' sahifa')
                    ->placeholder('—'),

                TextColumn::make('upload.file_path')
                    ->label('Hujjat')
                    ->formatStateUsing(fn ($state) => $state ? '📄Yuklangan' : 'Fayl yo\'q')
                    ->badge()
                    ->placeholder("Topilmadi")
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Yaratilgan')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Yangilangan')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->since()
                    ->description(fn ($record) => $record->updated_at->format('d.m.Y H:i'))
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Holati')
                    ->options([
                        'draft' => 'Qoralama',
                        'published' => 'Nashr etilgan',
                        'blocked' => 'Bloklangan',
                    ])
                    ->multiple()
                    ->searchable(),

                SelectFilter::make('language_id')
                    ->label('Til')
                    ->relationship('language', 'lang_name')
                    ->searchable()
                    ->multiple()
                    ->preload(),

                SelectFilter::make('work_id')
                    ->label('Asar')
                    ->relationship('work', 'title')
                    ->searchable()
                    ->multiple()
                    ->preload(),

                SelectFilter::make('translator_id')
                    ->label('Tarjimon')
                    ->relationship('translator.user', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->visible(fn () => auth()->user()->isAdmin()), // Only admins see this filter

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Boshlanishi'),
                        DatePicker::make('created_until')
                            ->label('Tugashi'),
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
                            $indicators[] = Indicator::make('Boshlanishi: ' . Carbon::parse($data['created_from'])->format('d.m.Y'))
                                ->removeField('created_from');
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Tugashi: ' . Carbon::parse($data['created_until'])->format('d.m.Y'))
                                ->removeField('created_until');
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->label(''),
                EditAction::make()
                    ->label('')
                    ->visible(function ($record) {
                        $user = auth()->user();

                        // Admins can edit everything
                        if ($user->isAdmin()) {
                            return true;
                        }

                        // Translators can only edit their own drafts
                        if ($user->isTranslator()) {
                            $portfolio = $user->translatorPortfolio;
                            return $portfolio &&
                                $record->translator_id === $portfolio->id &&
                                $record->status === 'draft';
                        }

                        return false;
                    }),
            ])
            ->emptyStateHeading('Hech qanday tarjima topilmadi')
            ->emptyStateDescription('Yangi tarjima qo\'shish uchun yuqoridagi tugmani bosing.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->deferLoading()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
    }
}
