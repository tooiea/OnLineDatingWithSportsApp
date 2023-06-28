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
            $table->charset = 'utf8mb4';
            $table->id();
            $table->string('team_name', 255);
            $table->integer('sport_affiliation_type');
            $table->string('invitation_code', 255);
            $table->integer('prefecture');
            $table->string('address', 255)->nullable();
            $table->string('team_url', 255)->nullable();
            $table->string('image_path', 255);
            $table->string('image_extension', 255);
            $table->integer('is_deleted')->default(0);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
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
