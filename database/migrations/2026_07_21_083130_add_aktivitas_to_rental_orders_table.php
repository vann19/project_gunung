<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rental_orders', function (Blueprint $table) {
            $table->string('jenis_aktivitas')->nullable()->after('alamat'); // pendakian / non_pendakian
            $table->string('tujuan_aktivitas')->nullable()->after('jenis_aktivitas'); // nama gunung / sungai / waduk / pantai
        });
    }

    public function down(): void
    {
        Schema::table('rental_orders', function (Blueprint $table) {
            $table->dropColumn(['jenis_aktivitas', 'tujuan_aktivitas']);
        });
    }
};
