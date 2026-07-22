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
        Schema::create('cuci_alats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('duration');
            $table->text('description')->nullable();
            $table->string('price');
            $table->string('unit')->default('/ item');
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuci_alats');
    }
};
