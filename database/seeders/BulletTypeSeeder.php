<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BulletType;

class BulletTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        BulletType::insert([
            ['name'=>'Rubber'],
            ['name'=>'Steel'],
            ['name'=>'Gas'],
        ]);
    }
}
