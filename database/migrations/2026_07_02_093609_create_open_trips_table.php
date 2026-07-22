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
        Schema::create('open_trips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('badge')->default('TERBUKA');
            $table->string('badge_class')->default('bg-secondary-400 text-surface-dark');
            $table->integer('slot')->default(10);
            $table->string('price');
            $table->json('features')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_trips');
    }
};
