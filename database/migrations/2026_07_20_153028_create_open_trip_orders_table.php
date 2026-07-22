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
        Schema::create('open_trip_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('trip_id')->constrained('open_trips')->onDelete('cascade');
            $table->string('penanggung_jawab');
            $table->string('whatsapp');
            $table->string('nik');
            $table->string('foto_ktp')->nullable();
            $table->string('surat_sehat')->nullable();
            $table->json('anggota')->nullable();
            $table->integer('total_peserta')->default(1);
            $table->integer('total_tagihan')->default(0);
            $table->string('status')->default('pending'); // pending, paid, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_trip_orders');
    }
};
