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
        Schema::create('teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 30);
            $table->integer('sport_affiliation_type');
            $table->integer('prefecture_code')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('favorite_facility', 30)->nullable();
            $table->string('url', 255)->nullable();
            $table->softDeletesTz('deleted_at', precision: 0);
            $table->timestampsTz(precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
