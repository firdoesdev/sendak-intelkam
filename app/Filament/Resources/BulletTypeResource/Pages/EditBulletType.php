<?php

namespace App\Filament\Resources\BulletTypeResource\Pages;

use App\Filament\Resources\BulletTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBulletType extends EditRecord
{
    protected static string $resource = BulletTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
