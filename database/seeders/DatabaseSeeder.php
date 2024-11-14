<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
            WeaponTypeSeeder::class
        ]);

        $user_handak = User::create(
            [
                'name' => 'Handak',
                'email' => 'handak@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ],

        );

        Role::insert([
            ['name' => 'handak','guard_name' => 'web'],
            ['name' => 'polsus','guard_name' => 'web'],
            ['name' => 'olahraga','guard_name' => 'web'],
            
        ]);

        $user_handak->assignRole('handak');

    }
}
