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
            $table->string('team_name', 50);
            $table->integer('sport_affiliation_type');
            $table->string('invitation_code', 255);
            $table->integer('prefecture_code');
            $table->string('address', 255);
            $table->string('team_url', 255);
            $table->string('image_path', 255);
            $table->string('image_extension', 255);
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
