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
        Schema::create('replies', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->id();
            $table->unsignedBigInteger('consent_game_id');
            $table->foreign('consent_game_id')->references('id')->on('consent_games')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('message');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
