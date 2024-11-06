<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Division::upsert([
            [
                'id' => 1,
                'name' => 'Handak',
            ],
            [
                'id' => 2,
                'name' => 'Polsus',
            ],
            [
                'id' => 3,
                'name' => 'Olahraga',
            ],
            [
                'id' => 4,
                'name' => 'Beladiri',
            ],
        ], ['id']);
    }
}
