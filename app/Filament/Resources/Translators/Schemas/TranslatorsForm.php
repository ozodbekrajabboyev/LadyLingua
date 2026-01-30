<?php

namespace App\Filament\Resources\Translators\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
//                        Select::make('user_id')
//                            ->label('User')
//                            ->relationship('user', 'name')
//                            ->searchable()
//                            ->preload()
//                            ->hidden()
//                            ->required()
//                            ->createOptionForm([
//                                TextInput::make('name')
//                                    ->required()
//                                    ->maxLength(255),
//                                TextInput::make('email')
//                                    ->email()
//                                    ->required()
//                                    ->maxLength(255),
//                            ])
//                            ->columnSpanFull(),

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

                Section::make('Languages & Proficiency')
                    ->description('Select languages you know and specify your proficiency level for each')
                    ->schema([
                        Repeater::make('languageProficiency')
                            ->label('Your Languages')
                            ->schema([
                                Select::make('available_language_id')
                                    ->label('Language')
                                    ->options(function () {
                                        return \App\Models\AvailableLanguage::pluck('lang_name', 'id');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live()
                                    ->placeholder('Select a language'),

                                Select::make('proficiency_level')
                                    ->label('Proficiency Level')
                                    ->options([
                                        'beginner' => '🌱 Beginner',
                                        'intermediate' => '📚 Intermediate',
                                        'advanced' => '🎓 Advanced',
                                        'native' => '🏆 Native Speaker',
                                    ])
                                    ->required()
                                    ->default('intermediate')
                                    ->placeholder('Select proficiency'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(20)
                            ->addActionLabel('+ Add Another Language')
                            ->reorderable()
                            ->collapsible()
                            ->collapsed(false)
                            ->itemLabel(fn (array $state): ?string =>
                            isset($state['available_language_id'])
                                ? \App\Models\AvailableLanguage::find($state['available_language_id'])?->lang_name
                                . ' - ' . ucfirst($state['proficiency_level'] ?? 'Not set')
                                : 'New Language'
                            )
                            ->columnSpanFull()
                            ->deleteAction(
                                fn ($action) => $action->requiresConfirmation()
                            ),
                    ]),

            ]);
    }
}
