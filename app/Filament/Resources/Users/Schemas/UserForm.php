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
                Select::make('role')
                    ->options([
                        'user' => 'User',
                        'translator' => 'Translator',
                        'admin' => 'Admin',
                    ])
                    ->required(),

                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'blocked' => 'Blocked',
                    ])
                    ->required(),
            ]);

    }
}
