<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\Owner;
use App\Models\RekomType;

use App\Enums\RekomStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekoms', function (Blueprint $table) {
            $table->id();
            $table->string('no_rekom')->nullable()->index();
            $table->date('activated_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->enum('status', [
                RekomStatusEnum::DRAFT->value(), 
                RekomStatusEnum::ACTIVE->value(), 
                RekomStatusEnum::EXPIRED->value(),
                RekomStatusEnum::EXPIRED_SOON->value()
                ])->default(RekomStatusEnum::DRAFT->value());
            // Has Many Relation with `Roles` from Spatie\Permission
            $table->foreignIdFor(Role::class)->nullable();
            $table->foreignIdFor(Owner::class)->nullable();
            $table->foreignIdFor(RekomType::class)->nullable();
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
