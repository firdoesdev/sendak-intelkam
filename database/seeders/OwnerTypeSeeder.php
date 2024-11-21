<?php

namespace Database\Seeders;

use App\Enums\OwnerTypeEnum;
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
            'name' => OwnerTypeEnum::INDIVIDUAL->value(),
            
        ]);

        \App\Models\OwnerType::create([
            'name' => OwnerTypeEnum::COMPANY->value(),
            
        ]);

    }
}
