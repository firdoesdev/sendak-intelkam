<?php

namespace App\Filament\Resources\BulletTypeResource\Pages;

use App\Filament\Resources\BulletTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBulletTypes extends ListRecords
{
    protected static string $resource = BulletTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
