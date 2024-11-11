<?php

namespace App\Filament\Resources\RekomTypeResource\Pages;

use App\Filament\Resources\RekomTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRekomType extends EditRecord
{
    protected static string $resource = RekomTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
