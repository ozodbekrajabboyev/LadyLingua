<?php

namespace App\Filament\Resources\Works\Schemas;

//use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Work Information')
                    ->description('Enter the details of the literary work')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter work title')
                            ->columnSpanFull(),

                        TextInput::make('author_name')
                            ->label('Author Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter author name'),

                        Select::make('original_language_id')
                            ->label('Original Language')
                            ->relationship('originalLanguage', 'lang_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('lang_name')
                                    ->label('Language Name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->helperText('Select the language the work was originally written in'),
                    ])
//                    ->columns(1),
            ]);
    }
}
