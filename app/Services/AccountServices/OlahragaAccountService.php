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
