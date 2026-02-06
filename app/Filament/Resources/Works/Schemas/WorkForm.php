<?php

namespace App\Filament\Resources\Works\Schemas;

//use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Asar haqida ma\'lumot')
                    ->description('Adabiy asar to\'liq ma\'lumotlarini kiriting')
                    ->icon('heroicon-o-book-open')
                    ->iconColor('primary')
                    ->collapsible()
                    ->schema([
                        TextInput::make('title')
                            ->label('Asar nomi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Asar nomini kiriting')
                            ->helperText('Asarning to\'liq nomi')
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-m-book-open')
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Asar tavsifi')
                            ->maxLength(1000)
                            ->rows(4)
                            ->placeholder('Asar haqida qisqacha ma\'lumot kiriting (ixtiyoriy)')
                            ->helperText('Foydalanuvchilarga ko\'rsatiladigan qisqacha tavsif')
                            ->columnSpanFull(),

                        TextInput::make('author_name')
                            ->label('Muallif ismi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Muallif to\'liq ismini kiriting')
                            ->helperText('Asar muallifining to\'liq ismi')
                            ->prefixIcon('heroicon-m-user-circle')
                            ->live(onBlur: true),

                        Select::make('original_language_id')
                            ->label('Asl tili')
                            ->relationship('originalLanguage', 'lang_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('Tilni tanlang')
                            ->native(false)
                            ->createOptionForm([
                                TextInput::make('lang_name')
                                    ->label('Til nomi')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Til nomini kiriting')
                                    ->helperText('Masalan: O\'zbek, Ingliz, Rus'),
                            ])
                            ->createOptionModalHeading('Yangi til qo\'shish')
                            ->editOptionForm([
                                TextInput::make('lang_name')
                                    ->label('Til nomi')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->prefixIcon('heroicon-m-language')
                            ->helperText('Asar dastlab qaysi tilda yozilganligini tanlang'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
