<?php

namespace App\Filament\Resources\Translators\Pages;

use App\Filament\Resources\Translators\TranslatorsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTranslators extends EditRecord
{
    protected static string $resource = TranslatorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
