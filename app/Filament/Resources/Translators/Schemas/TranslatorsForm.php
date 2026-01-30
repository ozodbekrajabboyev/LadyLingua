<?php

namespace App\Filament\Resources\Translators\Schemas;

use Filament\Forms\Components\FileUpload;
//use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TranslatorsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Translator Information')
                    ->description('Manage translator profile and details')
                    ->schema([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columnSpanFull(),

                        FileUpload::make('profile_image_url')
                            ->label('Profile Photo')
                            ->image()
                            ->disk('public')
                            ->directory('profiles')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull()
                            ->helperText('Upload a professional photo (max 2MB)'),

                        Textarea::make('bio')
                            ->label('Biography')
                            ->placeholder('Tell us about your translation experience, specializations, and expertise...')
                            ->maxLength(1000)
                            ->rows(6)
                            ->columnSpanFull()
                            ->helperText('Maximum 1000 characters'),
                    ])
                    ->columns(2),

                Section::make('Performance Metrics')
                    ->description('Track earnings and ratings')
                    ->schema([
                        TextInput::make('total_earnings')
                            ->label('Total Earnings')
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01)
                            ->required(),

                        TextInput::make('average_rating')
                            ->label('Average Rating')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1)
                            ->default(0)
                            ->suffix('⭐')
                            ->required()
                            ->helperText('Rating from 0 to 5'),
                    ])
                    ->columns(2),
            ]);
    }
}
