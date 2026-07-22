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
        Schema::create('marketplace_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('tents');
            $table->string('condition_badge')->default('Seperti Baru');
            $table->string('badge_class')->default('bg-secondary-400 text-surface-dark');
            $table->string('spec')->nullable();
            $table->string('price');
            $table->string('old_price')->nullable();
            $table->string('image')->default('/img/camping.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_items');
    }
};
