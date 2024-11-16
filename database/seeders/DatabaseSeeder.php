<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use SolutionForest\FilamentAccessManagement\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call Artisan Command for Filament User Permission for access menu Role & Permission
        Artisan::call('filament-access-management:install');

        $this->call([
            WarehouseSeeder::class,
            BulletTypeSeeder::class,
            WeaponTypeSeeder::class,
            OwnerTypeSeeder::class,
        ]);

        $roles = ['handak', 'polsus', 'beladiri', 'olahraga'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Asign Role to All Permission
        // Role::where('name', 'super-admin')->first()->givePermissionTo(Permission::all());

        $handakPermissions = [
            [
                'name' => 'rekoms.*',
                'http_path' => '/admin/rekoms'
            ],
            [
                'name'=>'logout.*',
                'http_path' => '/admin/logout'
            ]
        ];
        foreach ($handakPermissions as $handakPermission) {
            # code...
            $rekomPermission = Permission::firstOrCreate([
                'name' => $handakPermission['name'],
                'http_path' => $handakPermission['http_path'],
            ]);
            $rekomPermission->assignRole('Handak');
        }
        
        Role::where('name', 'handak')->first()->givePermissionTo(Permission::all());

        // Role::where('name', 'Polsus')->first()->givePermissionTo(Permission::all());
        // Role::where('name', 'Beladiri')->first()->givePermissionTo(Permission::all());
        // Role::where('name', 'Olahraga')->first()->givePermissionTo(Permission::all());

        

        // Buat users
          $users = [
           
            [
                'name' => 'User Handak',
                'email' => 'handak@example.com',
                'password' => Hash::make('password'),
                'role' => 'handak',
            ],
            [
                'name' => 'User Polsus',
                'email' => 'polsus@example.com',
                'password' => Hash::make('password'),
                'role' => 'polsus',
            ],
            [
                'name' => 'User Beladiri',
                'email' => 'beladiri@example.com',
                'password' => Hash::make('password'),
                'role' => 'beladiri',
            ],
            [
                'name' => 'User Olahraga',
                'email' => 'olahraga@example.com',
                'password' => Hash::make('password'),
                'role' => 'olahraga',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => $userData['password']]
            );

            // Assign role ke user
            $role = Role::where('name', $userData['role'])->first();
            $user->assignRole($role);
        }

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
}
