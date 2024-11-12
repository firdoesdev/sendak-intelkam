<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekoms', function (Blueprint $table) {
            $table->id();
            // Has Many Relation with `Roles` from Spatie\Permission
            $table->foreignId('role_id')
                ->references('id')
                ->on('roles')
                ->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekoms');
    }
};
