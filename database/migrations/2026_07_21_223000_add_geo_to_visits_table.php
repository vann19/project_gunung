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
        Schema::table('visits', function (Blueprint $table) {
            $table->string('city')->nullable()->after('ip')->index();
            $table->string('region')->nullable()->after('city')->index();
            $table->string('country')->nullable()->after('region')->index();
            $table->string('kecamatan')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['city','region','country','kecamatan']);
        });
    }
};
