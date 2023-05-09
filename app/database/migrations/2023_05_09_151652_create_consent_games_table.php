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
        Schema::create('consent_games', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->id();
            $table->unsignedBigInteger('invitee_id');
            $table->foreign('invitee_id')->references('id')->on('teams')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('guest_id');
            $table->foreign('guest_id')->references('id')->on('teams')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('consent_status');
            $table->dateTime('game_date')->nullable();
            $table->dateTime('first_preferered_date');
            $table->dateTime('second_preferered_date');
            $table->dateTime('third_preferered_date')->nullable();
            $table->text('message');
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
        Schema::dropIfExists('consent_games');
    }
};
