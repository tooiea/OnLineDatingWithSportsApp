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
        Schema::create('temp_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nickname', 20);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->integer('sport_affiliation_type')->nullable();
            $table->string('team_name', 255)->nullable();
            $table->string('team_url', 255)->nullable();
            $table->integer('prefecture_code')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('invitation_code', 255)->nullable();
            $table->timestampsTz(precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_users');
    }
};
