<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            WarehouseSeeder::class,
            BulletTypeSeeder::class,
            WeaponTypeSeeder::class,
            OwnerTypeSeeder::class,
        ]);

        // $roles = ['Handak', 'Polsus', 'Beladiri', 'Olahraga'];
        // foreach ($roles as $roleName) {
        //     Role::firstOrCreate(['name' => $roleName]);
        // }

        // $permissions = [
        //     'view reports',
        //     'create reports',
        //     'edit reports',
        //     'delete reports',
        //     'users.*'
        // ];

      
        // foreach ($permissions as $permissionName) {
        //     Permission::firstOrCreate(['name' => $permissionName]);
        // }

        // Role::where('name', 'Handak')->first()->givePermissionTo(Permission::all());
        // Role::where('name', 'Polsus')->first()->givePermissionTo(Permission::all());
        // Role::where('name', 'Beladiri')->first()->givePermissionTo(Permission::all());
        // Role::where('name', 'Olahraga')->first()->givePermissionTo(Permission::all());

        //   // Buat users
        //   $users = [
        //     [
        //         'name' => 'User Handak',
        //         'email' => 'handak@example.com',
        //         'password' => Hash::make('password'),
        //         'role' => 'Handak',
        //     ],
        //     [
        //         'name' => 'User Polsus',
        //         'email' => 'polsus@example.com',
        //         'password' => Hash::make('password'),
        //         'role' => 'Polsus',
        //     ],
        //     [
        //         'name' => 'User Beladiri',
        //         'email' => 'beladiri@example.com',
        //         'password' => Hash::make('password'),
        //         'role' => 'Beladiri',
        //     ],
        //     [
        //         'name' => 'User Olahraga',
        //         'email' => 'olahraga@example.com',
        //         'password' => Hash::make('password'),
        //         'role' => 'Olahraga',
        //     ],
        // ];

        // foreach ($users as $userData) {
        //     $user = User::firstOrCreate(
        //         ['email' => $userData['email']],
        //         ['name' => $userData['name'], 'password' => $userData['password']]
        //     );

        //     // Assign role ke user
        //     $role = Role::where('name', $userData['role'])->first();
        //     $user->assignRole($role);
        // }

    }
}
