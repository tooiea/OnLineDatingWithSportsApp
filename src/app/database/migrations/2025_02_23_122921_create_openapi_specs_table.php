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
        Schema::create('openapi_specs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->comment('APIドキュメント名');
            $table->text('description')->nullable()->comment('説明');
            $table->json('content')->comment('OpenAPI仕様書(JSON形式)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openapi_specs');
    }
};
