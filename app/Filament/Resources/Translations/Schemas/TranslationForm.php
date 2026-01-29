<?php

namespace App\Filament\Resources\Translations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TranslationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('work_id')
                    ->required()
                    ->numeric(),
                TextInput::make('translator_id')
                    ->required()
                    ->numeric(),
                TextInput::make('language_id')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('upload_id')
                    ->numeric(),
                TextInput::make('preview_pages_cnt')
                    ->required()
                    ->numeric(),
            ]);
    }
}
