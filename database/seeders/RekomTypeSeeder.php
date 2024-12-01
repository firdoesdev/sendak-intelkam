<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RekomType;

class RekomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'name' => 'Rekomendasi P1',
                'duration_in_month' => 6,
                // 'can_be_renewed' => true
            ],
            [
                'name' => 'Rekomendasi P2',
                'duration_in_month' => 6,
                // 'can_be_renewed' => true
            ],
            [
                'name' => 'Rekomendasi P3',
                'duration_in_month' => 12,
                // 'can_be_renewed' => true
            ]
        ];

        RekomType::insert($data);

    }
}
