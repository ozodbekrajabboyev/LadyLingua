<?php

namespace App\Filament\Resources\Translators\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
// use Filament\Forms\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TranslatorsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tarjimon Ma\'lumotlari')
                    ->description('Tarjimon profili va ma\'lumotlarini boshqarish')
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
                            ->label('Profil Rasmi')
                            ->image()
                            ->disk('public')
                            ->directory('profiles')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->columnSpanFull()
                            ->helperText('Professional rasm yuklang (maks. 2MB)'),

                        RichEditor::make('bio')
                            ->label('Biografiya')
                            ->placeholder('Tarjima tajribangiz, ixtisosligingiz va mahoratingiz haqida bizga aytib bering...')
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->helperText('Maksimal 1000 ta belgi'),
                    ])
                    ->columns(2),

                Section::make('Tillar va Bilim Darajasi')
                    ->description('O\'zingiz biladigan tillarni tanlang va har bir til uchun bilim darajangizni belgilang')
                    ->schema([
                        Repeater::make('languageProficiency')
                            ->label('Sizning Tillaringiz')
                            ->schema([
                                Select::make('available_language_id')
                                    ->label('Til')
                                    ->options(function () {
                                        return \App\Models\AvailableLanguage::pluck('lang_name', 'id');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live()
                                    ->placeholder('Tilni tanlang'),

                                Select::make('proficiency_level')
                                    ->label('Bilim Darajasi')
                                    ->options([
                                        'beginner' => '🌱 Boshlang\'ich',
                                        'intermediate' => '📚 O\'rta',
                                        'advanced' => '🎓 Yuqori',
                                        'native' => '🏆 Ona tili',
                                    ])
                                    ->required()
                                    ->default('intermediate')
                                    ->placeholder('Darajani tanlang'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(20)
                            ->addActionLabel('Til qo\'shish')
                            ->reorderable()
                            ->collapsible()
                            ->collapsed(false)
                            ->itemLabel(fn (array $state): ?string => isset($state['available_language_id'])
                                ? \App\Models\AvailableLanguage::find($state['available_language_id'])?->lang_name
                                .' - '.ucfirst($state['proficiency_level'] ?? 'Belgilanmagan')
                                : 'Yangi Til'
                            )
                            ->columnSpanFull()
                            ->deleteAction(
                                fn ($action) => $action->requiresConfirmation()
                            ),
                    ]),

            ]);
    }
}
