<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\BulletType;
use App\Models\WeaponType;
use App\Models\Warehouse;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->unique();
            $table->string('name');
            $table->string('caliber');
            $table->foreignIdFor(BulletType::class)->nullable();
            $table->foreignIdFor(WeaponType::class)->nullable();
            $table->foreignIdFor(Warehouse::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};