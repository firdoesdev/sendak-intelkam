<?php

namespace App\Services\AccountServices;
use App\Enums\RoleEnum;
use App\Services\AccountServices;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class OlahragaAccountService extends AccountServices
{
    /**
     * Create a new class instance.
     */
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
    
            //Weapon Menu
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
    ];

    private function createRole(): void
    {
        Role::firstOrCreate(['name' => RoleEnum::OLAHRAGA->value()]);
    }
    private function assignPermission(): void
    {
        foreach ($this->additionalPermissions as $permission) {
            $permissionCreate = Permission::firstOrCreate([
                'name' => $permission['name'],
                'http_path' => $permission['http_path']
            ]);
            $permissionCreate->assignRole(RoleEnum::OLAHRAGA->value());
        }

        Role::where('name', RoleEnum::OLAHRAGA->value())->first()->givePermissionTo(Permission::all());
    }
    public function initAccount(): void
    {
        $this->createRole();
        $this->assignPermission();

        $user = User::firstOrCreate([
            'name' => 'Olahraga',
            'email' => 'olahraga@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleEnum::OLAHRAGA->value());
    }
}
