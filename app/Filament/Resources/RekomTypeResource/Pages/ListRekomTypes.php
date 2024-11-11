<?php

namespace App\Filament\Resources\RekomTypeResource\Pages;

use App\Filament\Resources\RekomTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekomTypes extends ListRecords
{
    protected static string $resource = RekomTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
