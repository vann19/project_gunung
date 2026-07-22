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
        Schema::create('pendaki_bergabung', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('trip');
            $table->string('initial', 5)->nullable(); // auto-generated dari nama jika kosong
            $table->string('foto')->nullable();       // path foto upload
            $table->string('bg_class')->default('bg-primary');
            $table->string('text_class')->default('text-white');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaki_bergabung');
    }
};
