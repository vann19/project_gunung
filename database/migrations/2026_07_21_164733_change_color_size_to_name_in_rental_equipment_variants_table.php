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
        Schema::table('rental_equipment_variants', function (Blueprint $table) {
            $table->string('name')->nullable()->after('rental_equipment_id');
        });

        // Merge existing color and size into name
        DB::statement("UPDATE rental_equipment_variants SET name = CONCAT_WS(' - ', NULLIF(color, ''), NULLIF(size, ''))");

        Schema::table('rental_equipment_variants', function (Blueprint $table) {
            $table->dropColumn(['color', 'size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_equipment_variants', function (Blueprint $table) {
            $table->string('color')->nullable()->after('rental_equipment_id');
            $table->string('size')->nullable()->after('color');
        });

        DB::statement("UPDATE rental_equipment_variants SET color = name");

        Schema::table('rental_equipment_variants', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
