<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SolutionForest\FilamentAccessManagement\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'title' => 'Management Rekomendasi',
                'uri' => '/rekoms',
                'icon' => 'heroicon-o-home',
                'order' => 2,
                'parent_id' => -1,
            ],
            [
                'title' => 'Data Kepemilikan',
                'uri' => '/owners',
                'icon' => 'heroicon-o-home',
                'order' => 1,
                'parent_id' => 7,
            ],
            [
                'title' => 'Data Rekomendasi',
                'uri' => '/rekoms',
                'icon' => 'heroicon-o-home',
                'order' => 2,
                'parent_id' => 7,
            ],
            [
                'title' => 'Data Senjata',
                'uri' => '/weapons',
                'icon' => 'heroicon-o-home',
                'order' => 3,
                'parent_id' => 7,
            ],

            [
                'title' => 'Master Data',
                'uri' => '/master-data',
                'icon' => 'heroicon-o-home',
                'order' => 3,
                'parent_id' => -1,
            ], 

            [
                'title' => 'Jenis Senjata',
                'uri' => '/master-data/weapon-types',
                'icon' => 'heroicon-o-home',
                'order' => 2,
                'parent_id' => 11,
            ], 
            [
                'title' => 'Lokasi Gudang',
                'uri' => '/master-data/warehouses',
                'icon' => 'heroicon-o-home',
                'order' => 3,
                'parent_id' => 11,
            ], 
            [
                'title' => 'Rekom Type',
                'uri' => '/master-data/rekom-types',
                'icon' => 'heroicon-o-home',
                'order' => 1,
                'parent_id' => 11,
            ], 

            [
                'title' => 'Jenis Peluru',
                'uri' => '/master-data/bullet-types',
                'icon' => 'heroicon-o-home',
                'order' => 4,
                'parent_id' => 11,
            ], 
            [
                'title' => 'Documents',
                'uri' => '/documents',
                'icon' => 'heroicon-o-home',
                'order' => 4,
                'parent_id' => 11,
            ],
            [
                'title' => 'Document Templates',
                'uri' => '/document-templates',
                'icon' => 'heroicon-o-home',
                'order' => 5,
                'parent_id' => 11,
            ],
            

            
        ];

        foreach ($menus as $menu) {
            Menu::create([
                'title' => $menu['title'],
                'uri' => $menu['uri'],
                'icon' => $menu['icon'],
                'order' => $menu['order'],
                'parent_id' => $menu['parent_id'],
                'is_filament_panel'=>true
            ]);
        }
    }
}
