<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Weapon;

class WeaponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Weapon::insert([
            ['name'=>'M4-A1','serial'=>'M4-A1','weapon_type_id'=>1],
            ['name'=>'AK-47','serial'=>'AK-47','weapon_type_id'=>1],
            ['name'=>'Scar','serial'=>'Scar','weapon_type_id'=>1],
            ['name'=>'Famas','serial'=>'Famas','weapon_type_id'=>1],
            ['name'=>'XM8','serial'=>'XM8','weapon_type_id'=>1],
        ]);
        
        Weapon::insert([
            ['name'=>'MP5','serial'=>'MP5','weapon_type_id'=>2],
            ['name'=>'VMP','serial'=>'VMP','weapon_type_id'=>2],
            ['name'=>'VSS','serial'=>'VSS','weapon_type_id'=>2],
            ['name'=>'MP40','serial'=>'MP40','weapon_type_id'=>2],
            ['name'=>'P90','serial'=>'P90','weapon_type_id'=>2],
        ]);

        Weapon::insert([
            ['name'=>'M1014','serial'=>'M1014','weapon_type_id'=>3],
            ['name'=>'M1987','serial'=>'M1987','weapon_type_id'=>3],
            ['name'=>'MAG-7','serial'=>'MAG-7','weapon_type_id'=>3],
            ['name'=>'SPAS 12','serial'=>'SPAS 12','weapon_type_id'=>3],
        ]);

        Weapon::insert([
            ['name'=>'AWM','serial'=>'AWM','weapon_type_id'=>4],
            ['name'=>'KAT 98K','serial'=>'KAT 98K','weapon_type_id'=>4],
            ['name'=>'M82 B','serial'=>'M82 B','weapon_type_id'=>4],
            ['name'=>'M2T','serial'=>'M2T','weapon_type_id'=>4],
            ['name'=>'VSK94','serial'=>'VSK94','weapon_type_id'=>4],
        ]);

        Weapon::insert([
            ['name'=>'USP','serial'=>'USP','weapon_type_id'=>5],
            ['name'=>'Desert Eagle','serial'=>'Desert Eagle','weapon_type_id'=>5],
            ['name'=>'G18','serial'=>'G18','weapon_type_id'=>5],
            ['name'=>'M500','serial'=>'M500','weapon_type_id'=>5],
            ['name'=>'M1873','serial'=>'M1873','weapon_type_id'=>5],
        ]);

    }
}
