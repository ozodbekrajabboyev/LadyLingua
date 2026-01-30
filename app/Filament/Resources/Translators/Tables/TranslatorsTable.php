<?php

namespace App\Filament\Resources\Translators\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TranslatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_image_url')
                    ->label('Photo')
                    ->circular()
                    ->disk('public')
                    ->size(50)
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=User&color=7F9CF5&background=EBF4FF'),

                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                TextColumn::make('languages.lang_name')
                    ->label('Languages')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->tooltip(function ($record): string {
                        $languages = $record->languages->map(function ($lang) {
                            $proficiency = $lang->pivot->proficiency_level ?? 'N/A';
                            return $lang->lang_name . ' (' . ucfirst($proficiency) . ')';
                        })->join(', ');
                        return $languages ?: 'No languages';
                    })
                    ->searchable(),

//                TextColumn::make('bio')
//                    ->label('Biography')
//                    ->limit(50)
//                    ->wrap()
//                    ->tooltip(function ($record): ?string {
//                        return $record->bio;
//                    })
//                    ->toggleable(),

                TextColumn::make('total_earnings')
                    ->label('Earnings')
                    ->money('USD')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        $state >= 5000 => 'success',
                        $state >= 1000 => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('average_rating')
                    ->label('Rating')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match(true) {
                        $state >= 4.5 => 'success',
                        $state >= 3.5 => 'warning',
                        $state >= 2.0 => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) . ' ⭐' : 'No rating')
                    ->alignCenter(),

                TextColumn::make('completed_projects_count')
                    ->label('Projects')
                    ->counts('completedProjects')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->label('Joined')
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
                SelectFilter::make('languages')
                    ->label('Language')
                    ->relationship('languages', 'lang_name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('proficiency')
                    ->label('Proficiency Level')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                        'native' => 'Native Speaker',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder =>
                            $query->whereHas('languages', function ($q) use ($value) {
                                $q->where('proficiency_level', $value);
                            })
                        );
                    }),

                SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        '4.5+' => '4.5+ Stars',
                        '4.0+' => '4.0+ Stars',
                        '3.5+' => '3.5+ Stars',
                        '3.0+' => '3.0+ Stars',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder => $query->where(
                                'average_rating',
                                '>=',
                                floatval(str_replace('+', '', $value))
                            )
                        );
                    }),

                SelectFilter::make('earnings')
                    ->label('Earnings Range')
                    ->options([
                        '5000+' => '$5,000+',
                        '1000+' => '$1,000+',
                        '500+' => '$500+',
                        '100+' => '$100+',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder => $query->where(
                                'total_earnings',
                                '>=',
                                floatval(str_replace('+', '', $value))
                            )
                        );
                    }),

                Filter::make('has_bio')
                    ->label('Has Biography')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('bio')),

                Filter::make('has_photo')
                    ->label('Has Photo')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('profile_image_url')),

                Filter::make('new_translators')
                    ->label('New (Last 30 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(30))),
            ])
            ->actions([
//                ViewAction::make(),
//                EditAction::make(),
            ])
            ->bulkActions([
//                BulkActionGroup::make([
//                    DeleteBulkAction::make(),
//                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('No translators found')
            ->emptyStateDescription('Get started by creating your first translator profile.')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
