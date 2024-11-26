<?php

namespace App\Services\AccountServices;

use App\Enums\RoleEnum;
use App\Services\AccountServices;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;


class PolsusAccountService extends AccountServices
{
    

    private $additionalPermissions = [
        [
            'name' => 'rekoms.*',
            'http_path' => '/admin/rekoms',
        ],
        [
            'name' => 'rekoms.create',
            'http_path' => '/admin/rekoms/create',
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
    ];

    private function createRole(): void
    {
        Role::firstOrCreate(['name' => RoleEnum::POLSUS->value()]);
    }
    private function assignPermission(): void
    {
        foreach ($this->additionalPermissions as $permission) {
            $permissionCreate = Permission::firstOrCreate([
                'name' => $permission['name'],
                'http_path' => $permission['http_path']
            ]);
            $permissionCreate->assignRole(RoleEnum::POLSUS->value());
        }

        Role::where('name', RoleEnum::POLSUS->value())->first()->givePermissionTo(Permission::all());
    }
    public function initAccount(): void
    {
        $this->createRole();
        $this->assignPermission();

        $user = User::firstOrCreate([
            'name' => 'Polsus',
            'email' => 'polsus@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleEnum::POLSUS->value());
    }
}
