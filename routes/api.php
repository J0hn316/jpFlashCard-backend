<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\QuizResultController;
use App\Models\Word;

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


Route::get('/units', function () {
    return Word::query()
        ->select('unit')
        ->distinct()
        ->orderBy('unit')
        ->pluck('unit');
});

Route::middleware('auth:sanctum')->group(function () {
    // Get the authenticated user
    Route::get('/user', [AuthController::class, 'user']);

    // Logout (revoke current token)
    Route::post('/logout', [AuthController::class, 'logout']);

    // Word routes
    Route::get('/words', [WordController::class, 'all']);

    Route::get('/words/{unit}', [WordController::class, 'index']);
    // Create a new word (POST /api/words)
    Route::post('/words', [WordController::class, 'store']);
    // Update an existing word (PUT /api/words/{word})
    Route::put('/words/{word}', [WordController::class, 'update']);
    // Delete a word (DELETE /api/words/{word})
    Route::delete('/words/{word}', [WordController::class, 'destroy']);


    // Quiz results routes
    Route::get('/quiz-results', [QuizResultController::class, 'index']);
    Route::get('/quiz-results/summary', [QuizResultController::class, 'summary']);
    Route::post('/quiz-results', [QuizResultController::class, 'store']);
});
