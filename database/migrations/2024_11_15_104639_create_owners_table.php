<?php

use App\Models\OwnerType;
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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('no_ktp')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string(column: 'job')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_npwp')->nullable();
            $table->string('file_ksk')->nullable();
            $table->string('file_skep_jabatan')->nullable();
            $table->string('file_kta')->nullable();
            $table->string('file_surat_ijin_impor')->nullable();
            $table->string('file_tes_kesehatan')->nullable();
            $table->string('file_tes_psikologi')->nullable();
            $table->string('file_tes_menembak')->nullable();
            $table->foreignIdFor(model: OwnerType::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
