<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rental_equipments', function (Blueprint $table) {
            // sizes: [{"name":"S","stock":5},{"name":"M","stock":3}]
            $table->json('sizes')->nullable()->after('colors');
        });
    }

    public function down(): void
    {
        Schema::table('rental_equipments', function (Blueprint $table) {
            $table->dropColumn('sizes');
        });
    }
};
