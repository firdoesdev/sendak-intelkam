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
        'name' => 'owners.create',
        'http_path' => '/admin/owners/create',
    ],
    [
         'name' => 'owners.update',
         'http_path' => '/admin/owners/*/edit',
     ],
     [
         'name' => 'owners.view',
         'http_path' => '/admin/owners/*',
     ],
     [
         'name' => 'owners.viewAny',
         'http_path' => '/admin/owners',
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

       Role::where('name', RoleEnum::BELADIRI->value())->first()->givePermissionTo(Permission::all());
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
