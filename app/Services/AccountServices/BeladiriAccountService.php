<?php

namespace App\Services\AccountServices;

use App\Enums\RoleEnum;
use App\Services\AccountServices;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class BeladiriAccountService
{

    public function __construct()
    {
        //
    }

    private $additionalPermissions = [
        //Rekom Menu
        [
            'name' => 'rekoms.create',
            'http_path' => '/admin/rekoms/create',
        ],
        [
            'name' => 'rekoms.update',
            'http_path' => '/admin/rekoms/*/edit',
        ],
        [
            'name' => 'rekoms.view',
            'http_path' => '/admin/rekoms/*',
        ],
        [
            'name' => 'rekoms.viewAny',
            'http_path' => '/admin/rekoms',
        ],
        [
            'name' => 'logout.*',
            'http_path' => '/admin/logout',
        ],

        //Owner Menu
        [
            'name' => 'owners.*',
            'http_path' => '/admin/owners*',
        ],
        [
            'name' => 'owners.viewAny',
            'http_path' => '/admin/owners',
        ],
        [
            'name' => 'owners.view',
            'http_path' => '/admin/owners/*',
        ],
        [
            'name' => 'owners.create',
            'http_path' => '/admin/owners/create',
        ],
        [
            'name' => 'owners.update',
            'http_path' => '/admin/owners/*/edit',
        ],

        // //Weapon Menu
        [
            'name' => 'weapons.*',
            'http_path' => '/admin/weapons*',
        ],
        [
            'name' => 'weapons.viewAny',
            'http_path' => '/admin/weapons',
        ],
        [
            'name' => 'weapons.view',
            'http_path' => '/admin/weapons/*',
        ],
        [
            'name' => 'weapons.create',
            'http_path' => '/admin/weapons/create',
        ],
        [
            'name' => 'weapons.update',
            'http_path' => '/admin/weapons/*/edit',
        ],

        //Weapon Type Menu
        [
            'name' => 'weaponsTypes.*',
            'http_path' => '/admin/master-data/weapon-types*',
        ],
         [
            'name' => 'weaponsTypes.viewAny',
             'http_path' => '/admin/master-data/weapon-types',
         ],
        [
            'name' => 'weaponsTypes.view',
            'http_path' => '/admin/master-data/weapon-types/*',
        ],
        [
            'name' => 'weaponsTypes.create',
            'http_path' => '/admin/master-data/weapon-types/create',
        ],
        [
            'name' => 'weaponsTypes.update',
            'http_path' => '/admin/master-data/weapon-types/*/edit',
        ],

        //Gudang
        [
            'name' => 'warehouses.*',
            'http_path' => '/admin/master-data/warehouses*',
        ],
         [
            'name' => 'warehouses.viewAny',
             'http_path' => '/admin/master-data/warehouses',
         ],
        [
            'name' => 'warehouses.view',
            'http_path' => '/admin/master-data/warehouses/*',
        ],
        [
            'name' => 'warehouses.create',
            'http_path' => '/admin/master-data/warehouses/create',
        ],
        [
            'name' => 'warehouses.update',
            'http_path' => '/admin/master-data/warehouses/*/edit',
        ],

        //Jenis Peluru
        [
            'name' => 'bulletTypes.*',
            'http_path' => '/admin/master-data/bullet-types*',
        ],
         [
            'name' => 'bulletTypes.viewAny',
             'http_path' => '/admin/master-data/bullet-types',
         ],
        [
            'name' => 'bulletTypes.view',
            'http_path' => '/admin/master-data/bullet-types/*',
        ],
        [
            'name' => 'bulletTypes.create',
            'http_path' => '/admin/master-data/bullet-types/create',
        ],
        [
            'name' => 'bulletTypes.update',
            'http_path' => '/admin/master-data/bullet-types/*/edit',
        ],

        //Rekom Type
           
        [
            'name' => 'rekomTypes.*',
            'http_path' => '/admin/master-data/rekom-types*',
        ],
         [
            'name' => 'rekomTypes.viewAny',
             'http_path' => '/admin/master-data/rekom-types',
         ],
        [
            'name' => 'rekomTypes.view',
            'http_path' => '/admin/master-data/rekom-types/*',
        ],
        [
            'name' => 'rekomTypes.create',
            'http_path' => '/admin/master-data/rekom-types/create',
        ],
        [
            'name' => 'rekomTypes.update',
            'http_path' => '/admin/master-data/rekom-types/*/edit',
        ],
    ];

    private function createRole(): void
    {
        Role::firstOrCreate(['name' => RoleEnum::BELADIRI->value()]);
    }
    private function assignPermission(): void
    {
        foreach ($this->additionalPermissions as $permission) {
            $permissionCreate = Permission::firstOrCreate([
                'name' => $permission['name'],
                'http_path' => $permission['http_path']
            ]);
            $permissionCreate->assignRole(RoleEnum::BELADIRI->value());
        }

        // Assign All Permission if environment is `local`
        if(app()->environment('local')){
            Role::where('name', RoleEnum::BELADIRI->value())->first()->givePermissionTo(Permission::all());
        }
    }
    public function initAccount(): void
    {
        $this->createRole();
        $this->assignPermission();

        $user = User::firstOrCreate([
            'name' => 'Beladiri',
            'email' => 'beladiri@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleEnum::BELADIRI->value());

     
    }
}
