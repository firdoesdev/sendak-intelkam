<?php

namespace App\Services\RekomServices;

use Spatie\Permission\Models\Role;
use App\Enums\RoleEnum;
use App\Services\RekomServices;

interface CommonRekomServiceInterface{
    public function getRekomRoleId();
}


class CommonRekomService extends RekomServices implements CommonRekomServiceInterface
{
    public function __construct()
    {
        //
    }

    public function getRekomRoleId(){
        $user = auth()->user();

        if($user->hasRole(RoleEnum::BELADIRI->value())){                
            return Role::where('name', RoleEnum::BELADIRI->value())->first()->id;
        }

        if($user->hasRole(RoleEnum::HANDAK->value())){                
            return Role::where('name', RoleEnum::HANDAK->value())->first()->id;
        }

        if($user->hasRole(RoleEnum::POLSUS->value())){                
            return Role::where('name', RoleEnum::POLSUS->value())->first()->id;
        }

        if($user->hasRole(RoleEnum::OLAHRAGA->value())){                
            return Role::where('name', RoleEnum::OLAHRAGA->value())->first()->id;
        }
    }

    public function activateDate(){
        return now();
    }

    public function expiredDate(){
        return now()->addYear();
    }

}
