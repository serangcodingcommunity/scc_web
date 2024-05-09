<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UsersController;

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
Route::delete('/posts/{id}/unlike', [PostController::class, 'unlike'])->middleware('auth:sanctum');

/* Feedback */
Route::post('/feedbacks', [FeedbackController::class, 'store'])->middleware('auth:sanctum');
Route::get('/events/{id}/feedbacks', [FeedbackController::class, 'index'])->middleware('auth:sanctum');

/* Users */
Route::get('/users', [UsersController::class, 'index'])->middleware('auth:sanctum');
Route::put('/users/{id}', [UsersController::class, 'update'])->middleware('auth:sanctum');

/* Members */
Route::post('/members', [UsersController::class, 'storeMember'])->middleware('auth:sanctum');
Route::put('/members/{id}', [UsersController::class, 'updateMember'])->middleware('auth:sanctum');

/* Pekerjaan */
Route::post('/pekerjaan', [UsersController::class, 'storePekerjaan'])->middleware('auth:sanctum');
Route::put('/pekerjaan/{id}', [UsersController::class, 'updatePekerjaan'])->middleware('auth:sanctum');
Route::delete('/pekerjaan/{id}', [UsersController::class, 'destroyPekerjaan'])->middleware('auth:sanctum');

/* Pendidikan */
Route::post('/pendidikan', [UsersController::class, 'storePendidikan'])->middleware('auth:sanctum');
Route::put('/pendidikan/{id}', [UsersController::class, 'updatePendidikan'])->middleware('auth:sanctum');
Route::delete('/pendidikan/{id}', [UsersController::class, 'destroyPendidikan'])->middleware('auth:sanctum');

/* Sosmed */
Route::post('/sosmed', [UsersController::class, 'storeSosmed'])->middleware('auth:sanctum');
Route::put('/sosmed/{id}', [UsersController::class, 'updateSosmed'])->middleware('auth:sanctum');
Route::delete('/sosmed/{id}', [UsersController::class, 'destroySosmed'])->middleware('auth:sanctum');

/* Portofolio */
Route::post('/portofolio', [UsersController::class, 'storePortofolio'])->middleware('auth:sanctum');
Route::put('/portofolio/{id}', [UsersController::class, 'updatePortofolio'])->middleware('auth:sanctum');
Route::delete('/portofolio/{id}', [UsersController::class, 'destroyPortofolio'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('apps')->group(function () {
    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
    });
});