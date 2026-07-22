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
        Schema::table('hiking_guides', function (Blueprint $table) {
            $table->integer('slot')->default(10)->after('badge_class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hiking_guides', function (Blueprint $table) {
            $table->dropColumn('slot');
        });
    }
};
