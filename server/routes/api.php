<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;

/* Auth */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UsersController::class, 'show'])->middleware('auth:sanctum');
Route::post('/users/upload', [UsersController::class, 'upload'])->middleware('auth:sanctum');
// Route::put('/users/{id}/upload', [UsersController::class, 'upload'])->middleware('auth:sanctum');

/* GithubAuth */
Route::get('/github/redirect', [AuthController::class, 'refreshGithub']);
Route::get('/github/callback', [AuthController::class, 'callbackGithub']);

/* GoogleAuth */
Route::get('/google/redirect', [AuthController::class, 'refreshGoogle']);
Route::get('/google/callback', [AuthController::class, 'callbackGoogle']);

/* Category */
Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');
Route::post('/categories', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('apps')->group(function () {
    Route::group(['middleware' => ['auth']], function () {
    });
});
