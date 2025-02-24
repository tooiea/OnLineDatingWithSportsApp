<?php

use App\Http\Controllers\Api\AuthenticatedSessionController;
use App\Http\Controllers\Api\OpenApiSpecController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('openapi-specs', OpenApiSpecController::class);

Route::get('openapi-specs/latest', function () {
    $latestSpec = \App\Models\OpenApiSpec::latest()->first();
    return response()->json($latestSpec->content);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthenticatedSessionController::class, 'login'])->name('api-login');
});


// Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('team', TeamController::class, [
        'parameters' => ['team' => 'team_id'],
        'names' => 'api-team'
    ])->except(['index', 'destroy']);
// });