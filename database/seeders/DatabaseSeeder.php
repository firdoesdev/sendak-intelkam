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



class DatabaseSeeder extends Seeder 
{
    private $handakAccountService;
    public function __construct(HandakAccountService $handakAccountService){
        $this->handakAccountService = $handakAccountService;
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

        $this->createMenu();

    }

    private function createMenu():void
    {
        $menus = [
            [
                'title' => 'Rekomendasi',
                'uri' => '/rekoms',
                'icon' => 'heroicon-o-home',
                'order' => 1,
                'parent_id' => null,
            ]
        ];

        foreach ($menus as $menu) {
            Menu::create([
                'title' => $menu['title'],
                'uri' => $menu['uri'],
                'icon' => $menu['icon'],
                'order' => $menu['order'],
                'parent_id' => $menu['parent_id'],
            ]);
        }
    }


  
}
