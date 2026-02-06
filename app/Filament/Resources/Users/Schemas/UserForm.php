<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Ism')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone_number')
                    ->label('Telefon raqami')
                    ->prefix('+998')
                    ->placeholder('90 123 45 67')
                    ->mask('99 999 99 99')
                    ->tel()
                    ->maxLength(12)
                    ->rules(['regex:/^[0-9\s]*$/'])
                    ->helperText('Telefon raqamingizni +998 prefiksi bilan kiriting'),

                TextInput::make('password')
                    ->label('Parol')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),

                Select::make('role')
                    ->label('Rol')
                    ->options([
                        'user' => 'Foydalanuvchi',
                        'translator' => 'Tarjimon',
                        'admin' => 'Admin',
                    ])
                    ->required(),

                Select::make('status')
                    ->label('Holat')
                    ->options([
                        'active' => 'Faol',
                        'blocked' => 'Bloklangan',
                    ])
                    ->required(),
            ]);

    }
}
