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
        Schema::create('rental_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->string('nama_lengkap');
            $table->string('nomor_wa');
            $table->string('nik_ktp');
            $table->text('alamat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('foto_ktp');
            $table->json('items');
            $table->bigInteger('total_price');
            $table->string('status')->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_orders');
    }
};
