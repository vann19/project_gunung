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
        Schema::create('rental_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('camping'); // camping, kelompok, masak, makan, piknik, grill, pribadi, hydropack
            $table->string('price'); // e.g. "Rp 45k"
            $table->enum('condition_badge', ['Baru', 'Second'])->default('Baru');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_equipments');
    }
};
