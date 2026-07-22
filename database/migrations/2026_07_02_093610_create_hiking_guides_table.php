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
        Schema::create('hiking_guides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('badge')->default('SERTIFIKASI APGI');
            $table->string('badge_class')->default('bg-secondary-400 text-surface-dark');
            $table->string('price');
            $table->string('unit')->default('/ hari');
            $table->json('features')->nullable();
            $table->string('image')->default('/img/Guide helping climber.png');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hiking_guides');
    }
};
