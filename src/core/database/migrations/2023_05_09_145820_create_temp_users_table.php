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
            $table->charset = 'utf8mb4';
            $table->id();
            $table->string('name', 20);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('token', 255);
            $table->dateTime('expiration_date');
            $table->integer('sport_affiliation_type')->nullable();
            $table->string('team_name', 255)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->string('image_extension', 255)->nullable();
            $table->string('team_url', 255)->nullable();
            $table->integer('prefecture')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('invitation_code', 255)->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
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
