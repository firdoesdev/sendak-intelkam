<?php

namespace App\Services;

use App\Enums\OwnerTypeEnum;
use App\Enums\RoleEnum;
use App\Models\OwnerType;
class OwnerServices
{
    public function defaultOwnerType(){
        $user = auth()->user();

    //    if($user->hasRole(RoleEnum::POLSUS->value())){

    //    }

        return OwnerType::where('name',OwnerTypeEnum::INDIVIDUAL->value())->first();
    }
}
