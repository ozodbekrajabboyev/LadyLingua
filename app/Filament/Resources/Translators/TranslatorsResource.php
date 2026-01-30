<?php

namespace App\Filament\Resources\Translators;

use App\Filament\Resources\Translators\Pages\CreateTranslators;
use App\Filament\Resources\Translators\Pages\EditTranslators;
use App\Filament\Resources\Translators\Pages\ListTranslators;
use App\Filament\Resources\Translators\Schemas\TranslatorsForm;
use App\Filament\Resources\Translators\Tables\TranslatorsTable;
use App\Models\TranslatorPortfolio;
use App\Models\Translators;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TranslatorsResource extends Resource
{
    protected static ?string $model = TranslatorPortfolio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TranslatorPortfolio';

    public static function form(Schema $schema): Schema
    {
        return TranslatorsForm::configure($schema);
    }
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function table(Table $table): Table
    {
        return TranslatorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTranslators::route('/'),
            'create' => CreateTranslators::route('/create'),
            'edit' => EditTranslators::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Prevent manual creation, portfolios are created automatically
    }
}
