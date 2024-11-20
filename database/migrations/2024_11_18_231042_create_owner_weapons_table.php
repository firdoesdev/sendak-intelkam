<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Owner;
use App\Models\Weapon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('owner_weapon', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Weapon::class)->nullable();
            $table->foreignIdFor(Owner::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_weapons');
    }
};
