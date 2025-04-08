<?php

use App\Models\Team;
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
            $table->uuid('id')->primary();
            $table->foreignIdFor(Team::class, 'invitee_id');
            $table->foreignIdFor(Team::class, 'guest_id');
            $table->integer('consent_status');
            $table->dateTime('game_date')->nullable();
            $table->dateTime('first_preferered_date');
            $table->dateTime('second_preferered_date');
            $table->dateTime('third_preferered_date')->nullable();
            $table->text('message')->nullable();
            $table->softDeletes('deleted_at', precision: 0);
            $table->timestampsTz(precision: 0);
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
