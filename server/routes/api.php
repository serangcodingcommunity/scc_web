<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FeedbackController;


/* Auth */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/reset-password', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum');
// Route::get('/logout', [AuthController::class, 'logout']);

/* OAuth Google */
Route::get('/redirect', [AuthController::class, 'refresh']);
Route::get('/google/callback', [AuthController::class, 'callback']);

/* Category */
Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->middleware('auth:sanctum');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');

/* Posts */
Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::post('/posts/{id}/comment', [PostController::class, 'comment'])->middleware('auth:sanctum');
Route::post('/posts/{id}/like', [PostController::class, 'like'])->middleware('auth:sanctum');
Route::get('/posts', [PostController::class, 'index'])->middleware('auth:sanctum');
Route::get('/posts/{id}', [PostController::class, 'show'])->middleware('auth:sanctum');
Route::put('/posts/{id}', [PostController::class, 'update'])->middleware('auth:sanctum');
Route::patch('/posts/{id}', [PostController::class, 'publish'])->middleware('auth:sanctum');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('auth:sanctum');

/* Feedback */
Route::post('/feedbacks', [FeedbackController::class, 'store'])->middleware('auth:sanctum');
Route::get('/events/{id}/feedbacks', [FeedbackController::class, 'index'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('apps')->group(function () {
    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
    });
});