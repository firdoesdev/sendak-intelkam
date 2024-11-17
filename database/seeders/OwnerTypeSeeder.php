<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\OwnerType::create([
            'name' => 'Individual',
            
        ]);

        \App\Models\OwnerType::create([
            'name' => 'Company',
            
        ]);

    }
}
