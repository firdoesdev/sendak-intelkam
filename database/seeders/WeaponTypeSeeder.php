<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WeaponType;

class WeaponTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // WeaponType::factory(3)->create();

        WeaponType::insert([
            ['name'=>'Rifles'],
            ['name'=>'SMG'],
            ['name'=>'Shotgun'],
            ['name'=>'Sniper'],
            ['name'=>'Pistol'],
        ]);

    }
}
