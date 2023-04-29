<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('session', [SessionController::class, 'create']);
Route::middleware('session')->post('quiz', [QuizController::class, 'create']);
Route::middleware('session')->post('quiz/{quizId}/finish', [QuizController::class, 'finish']);
Route::middleware('session')->post('quiz/{quizId}/{questionId}/answer', [QuizController::class, 'answerQuestion']);
Route::get('stats', [StatsController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('questions', [QuestionController::class, 'index']);
    Route::post('question', [QuestionController::class, 'store']);
    Route::get('stats-detailed', [StatsController::class, 'indexDetailed']);
});
Route::post('/authenticate', [AccountController::class, 'login']);