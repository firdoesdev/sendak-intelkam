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

        
        $this->handakAccountService->createAccount();

    }


  
}
