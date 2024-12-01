<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use SolutionForest\FilamentAccessManagement\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

use App\Services\AccountServices\HandakAccountService;
use App\Services\AccountServices\PolsusAccountService;
use App\Services\AccountServices\BeladiriAccountService;
use App\Services\AccountServices\OlahragaAccountService;



class DatabaseSeeder extends Seeder 
{
    private $handakAccountService;
    private $polsusAccountService;
    private $olahragaAccountService;
    private $beladiriAccountService;
    public function __construct(HandakAccountService $handakAccountService,PolsusAccountService $polsusAccountService, BeladiriAccountService $beladiriAccountService, OlahragaAccountService $olahragaAccountService){
        $this->handakAccountService = $handakAccountService;
        $this->polsusAccountService = $polsusAccountService;
        $this->beladiriAccountService = $beladiriAccountService;
        $this->olahragaAccountService = $olahragaAccountService;
    }
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call Artisan Command for Filament User Permission for access menu Role & Permission
        Artisan::call('filament-access-management:install');

        $this->call([
            WarehouseSeeder::class,
            BulletTypeSeeder::class,
            WeaponTypeSeeder::class,
            OwnerTypeSeeder::class,
        ]);

        
        $this->handakAccountService->initAccount();
        $this->polsusAccountService->initAccount();
        $this->olahragaAccountService->initAccount();
        $this->beladiriAccountService->initAccount();

        $this->createMenu();

    }

    private function createMenu():void
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
