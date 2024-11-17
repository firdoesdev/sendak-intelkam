<?php

namespace App\Services\AccountServices;
use App\Enums\RoleEnum;
use App\Services\AccountServices;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use SolutionForest\FilamentAccessManagement\Models\Menu;

use App\Models\User;

class HandakAccountService extends AccountServices
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    protected function createRole():void{
        Role::firstOrCreate(['name' => RoleEnum::HANDAK->value()]);   
    }

    protected function additionalPermissions(): array{
        return [
            [
                'name' =>'rekoms.*',
                'http_path' => '/admin/rekoms',
            ],
            [
                'name' =>'rekoms.create',
                'http_path' => '/admin/rekoms/create',
            ],
           
            [
                'name' =>'logout.*',
                'http_path' => '/admin/logout',
            ],
        ];
    }

    public function assignPermission() : void {
        foreach ($this->additionalPermissions() as $permission) {
            $permissionCreate = Permission::firstOrCreate([
                'name' => $permission['name'],
                'http_path' => $permission['http_path']
            ]);
            $permissionCreate->assignRole(RoleEnum::HANDAK->value());
        }

        Role::where('name', RoleEnum::HANDAK->value())->first()->givePermissionTo(Permission::all());
    }

    protected function createMenu():void
    {
        $menus = [
            [
                'title' => 'Rekomendasi',
                'uri' => '/rekoms',
                'icon' => 'heroicon-o-home',
                'order' => 1,
                'parent_id' => null,
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create([
                'title' => $menu['title'],
                'uri' => $menu['uri'],
                'icon' => $menu['icon'],
                'order' => $menu['order'],
                'parent_id' => $menu['parent_id'],
            ]);
        }
    }

    public function createAccount():void
    {
        $this->createRole();
        $this->assignPermission();
        $this->createMenu();

        $handakUser = User::firstOrCreate([
            'name' => 'Handak',
            'email' => 'handak@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $handakUser->assignRole(RoleEnum::HANDAK->value());

        

    }
}
