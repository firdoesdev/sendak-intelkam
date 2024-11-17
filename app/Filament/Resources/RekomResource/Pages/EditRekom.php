<?php

namespace App\Filament\Resources\RekomResource\Pages;

use App\Filament\Resources\RekomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRekom extends EditRecord
{
    protected static string $resource = RekomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
