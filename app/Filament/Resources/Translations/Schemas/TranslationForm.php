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

                                Select::make('language_id')
                                    ->label('Tarjima tili')
                                    ->relationship('language', 'lang_name')
                                    ->searchable()
                                    ->preload()
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
                    ->description('Tarjima hujjati va ko\'rib chiqish sahifalari')
                    ->schema([
                        FileUpload::make('upload_id')
                            ->label('Tarjima hujjati')
                            ->disk('public')
                            ->directory('translations')
                            ->visibility('private')
                            ->preserveFilenames()
                            ->openable()
                            ->downloadable()
                            ->previewable(true)
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240) // 10MB
                            ->helperText('PDF, DOC yoki DOCX formatida yuklang (maksimal 10MB)')
                            ->saveUploadedFileUsing(function ($file, $get) {
                                $translatorId = $get('translator_id');
                                if (!$translatorId && auth()->user()->role === 'translator') {
                                    $translatorId = auth()->user()->translatorPortfolio?->id;
                                }

                                $upload = \App\Models\Upload::create([
                                    'translator_id' => $translatorId,
                                    'file_path' => $file->store('translations', 'public'),
                                ]);

                                return $upload->id;
                            })
                            ->afterStateHydrated(function ($state, $set, $record) {
                                if ($record && $record->upload_id) {
                                    $upload = \App\Models\Upload::find($record->upload_id);
                                    if ($upload && $upload->file_path) {
                                        $set('upload_id', $upload->file_path);
                                    }
                                }
                            })
                            ->afterStateUpdated(function ($state, $get, $set, $record) {
                                if ($state && $record) {
                                    if ($record->upload_id) {
                                        $oldUpload = \App\Models\Upload::find($record->upload_id);
                                        if ($oldUpload && $oldUpload->file_path) {
                                            \Storage::disk('public')->delete($oldUpload->file_path);
                                            $oldUpload->delete();
                                        }
                                    }
                                }
                            })
                            ->columnSpanFull(),

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
