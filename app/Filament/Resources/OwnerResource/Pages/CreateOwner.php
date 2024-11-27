<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;


class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Tambah Data Kepemilikan');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $new_owner = static::getModel()::create($data);
        $new_owner->rekoms()->create([
            'owner_id' => $new_owner->id
        ]);
        
        return $new_owner;
    }
}
