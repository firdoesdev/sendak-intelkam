<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Database\Eloquent\Model;


class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $new_owner = static::getModel()::create($data);
        $new_owner->rekoms()->create([
            'owner_id' => $new_owner->id
        ]);
        
        return $new_owner;
    }
}
