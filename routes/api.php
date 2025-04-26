<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the bootstrap/app.php via the `install:api`
| command, and are wrapped in the `api` middleware group with Sanctum
| token protection automatically applied.
|
*/

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Get the authenticated user
Route::middleware('auth:sanctum')->group(function () {
    // Get the authenticated user
    Route::get('/user', [AuthController::class, 'user']);

    // Logout (revoke current token)
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/words/{unit}', [WordController::class, 'index']);
});
