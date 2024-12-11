<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use App\Models\OwnerType;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Enums\OwnerTypeEnum;
use App\Enums\RoleEnum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Htmlable;


class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Tambah Data Kepemilikan');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['owner_type_id'] = $this->getOwnerType()->id;
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $ownerType = $this->getOwnerType();
        //Create first rekom with default new owner
        $new_owner = static::getModel()::create($data);
        $new_owner->rekoms()->create([
            'owner_id' => $new_owner->id
        ]);

        return $new_owner;
    }

    private function getOwnerType(): OwnerType
    {
        /**
         *  if Beladiri or Olahraga , set to individual ownership
         */
        $user = auth()->user();

        // dd(OwnerType::where('name', OwnerTypeEnum::COMPANY->value())->first()->id);

        if($user->hasRole(RoleEnum::BELADIRI->value()) || $user->hasRole(RoleEnum::OLAHRAGA->value())){
            return OwnerType::where('name', OwnerTypeEnum::INDIVIDUAL->value())->first();
        }
        
        return OwnerType::where('name', OwnerTypeEnum::COMPANY->value())->first();
        
    }
}
