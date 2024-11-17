<?php

namespace App\Filament\Resources\RekomResource\Pages;

use App\Filament\Resources\RekomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekoms extends ListRecords
{
    protected static string $resource = RekomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
