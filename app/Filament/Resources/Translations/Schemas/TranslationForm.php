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

                Section::make('Translation Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('work_id')
                                    ->label('Work')
                                    ->options(Work::all()->pluck('title', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->placeholder('Select a work to translate'),
                                Select::make('language_id')
                                    ->label('Target Language')
                                    ->options(AvailableLanguage::all()->pluck('lang_name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->placeholder('Select target language'),
                            ])
                    ]),

                Section::make('Assignment & Pricing')
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
                                    ->label('Translation Status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'blocked' => 'Blocked'
                                    ])
                                    ->default('draft')
                                    ->required(),

                                TextInput::make('price')
                                    ->label('Translation Price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->maxValue(99999.99)
                                    ->required()
                                    ->placeholder('0.00'),
                            ])
                    ]),

                Section::make('Additional Information')
                    ->schema([
                        // CRITICAL: For file uploads to persist properly on edit/view:
                        // 1. The field name should match the relationship or column
                        // 2. Use relationship() method if linking to related model
                        // 3. Or store the file path directly in a column

                        FileUpload::make('upload_id')
                            ->label('Translation Document')
                            ->disk('public')
                            ->directory('translations')
                            ->visibility('private')
                            ->preserveFilenames()
                            // Enable file preview/download on edit
                            ->openable()  // Allows opening file in new tab
                            ->downloadable()  // Adds download button
                            // For better UX, show file info without re-downloading
                            ->previewable(true)
                            // Handle custom file saving logic
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
                            // CRITICAL: Load existing file on edit
                            ->afterStateHydrated(function ($state, $set, $record) {
                                // This runs when form loads for editing
                                if ($record && $record->upload_id) {
                                    $upload = \App\Models\Upload::find($record->upload_id);
                                    if ($upload && $upload->file_path) {
                                        // Set the file path so FileUpload can display it
                                        $set('upload_id', $upload->file_path);
                                    }
                                }
                            })
                            // Handle file updates/replacements
                            ->afterStateUpdated(function ($state, $get, $set, $record) {
                                // This runs when a new file is uploaded during edit
                                if ($state && $record) {
                                    // Optional: Delete old file before uploading new one
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
                            ->label('Preview Pages Count')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ]),
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
