<?php

namespace App\Filament\Resources\Translations\Schemas;

use App\Models\AvailableLanguage;
use App\Models\TranslatorPortfolio;
use App\Models\Work;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TranslationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Tarjima ma\'lumotlari')
                    ->description('Asosiy tarjima ma\'lumotlarini kiriting')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('work_id')
                                    ->label('Asar')
                                    ->relationship('work', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->placeholder('Tarjima qilinadigan asarni tanlang')
                                    ->live()
                                    ->helperText('Tarjima qilmoqchi bo\'lgan asaringizni tanlang'),

//                                use App\Models\AvailableLanguage;

                                Select::make('language_id')
                                    ->label('Tarjima tili')
                                    ->options(
                                        AvailableLanguage::query()
                                            ->pluck('lang_name', 'id')
                                            ->toArray()
                                    )
                                    ->searchable()
                                    ->required()
                                    ->placeholder('Maqsadli tilni tanlang')
                                    ->helperText('Asar qaysi tilga tarjima qilinadi'),

                            ])
                    ])
                    ->collapsible(),

                Section::make('Holat va narx')
                    ->description('Tarjima holati va narxini belgilang')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                \Filament\Forms\Components\Hidden::make('translator_id')
                                    ->default(function () {
                                        if (auth()->user()->role === 'translator') {
                                            return auth()->user()->translatorPortfolio?->id;
                                        }
                                        return null;
                                    }),

                                Select::make('status')
                                    ->label('Holati')
                                    ->options([
                                        'draft' => 'Qoralama',
                                        'published' => 'Nashr etilgan',
                                        'blocked' => 'Bloklangan'
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->native(false)
                                    ->helperText('Tarjimaning joriy holati'),

                                TextInput::make('price')
                                    ->label('Narxi')
                                    ->numeric()
                                    ->suffix('UZS')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->maxValue(10000000)
                                    ->required()
                                    ->placeholder('0.00')
                                    ->helperText('Tarjima narxini kiriting (Sumda)')
                                    ->live(onBlur: true),
                            ])
                    ])
                    ->collapsible(),

                Section::make('Qo\'shimcha ma\'lumotlar')
                    ->description('Tarjima hujjatlari')
                    ->schema([
                        FileUpload::make('preview_pdf_path')
                            ->label('Ko\'rab chiqish uchun PDF')
                            ->disk('public')
                            ->directory('translations/preview')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->required()
                            ->helperText('Foydalanuvchilar ko\'rishi uchun PDF (maksimal 5MB)')
                            ->columnSpanFull()
                            ->storeFileNamesIn('preview_pdf_original_name'), // Add this

                        FileUpload::make('full_pdf_path')
                            ->label('To\'liq tarjima PDF')
                            ->disk('public')
                            ->directory('translations/full')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->required()
                            ->helperText('To\'liq tarjima fayli (maksimal 5MB)')
                            ->columnSpanFull()
                            ->storeFileNamesIn('full_pdf_original_name'),
                        TextInput::make('preview_pages_cnt')
                            ->label('Ko\'rib chiqish sahifalari soni')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(1000)
                            ->suffix('sahifa')
                            ->helperText('Bepul ko\'rib chiqish uchun ruxsat berilgan sahifalar soni')
                            ->live(onBlur: true),
                    ])
                    ->collapsible(),
            ]);
    }

    /**
     * Alternative approach using relationship
     * If you want to use Filament's built-in relationship handling
     */
    public static function configureWithRelationship(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ... other sections remain same

                Section::make('Additional Information')
                    ->schema([
                        // Using relationship method for automatic handling
                        FileUpload::make('file_path')
                            ->label('Translation Document')
                            ->relationship('upload', 'file_path')  // Relationship name and column
                            ->disk('public')
                            ->directory('translations')
                            ->visibility('private')
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->previewable(true)
                            ->columnSpanFull(),

                        TextInput::make('preview_pages_cnt')
                            ->label('Preview Pages Count')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ]),
            ]);
    }
}
