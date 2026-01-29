<?php

namespace App\Filament\Resources\Translators\Pages;

use App\Filament\Resources\Translators\TranslatorsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTranslators extends ListRecords
{
    protected static string $resource = TranslatorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
