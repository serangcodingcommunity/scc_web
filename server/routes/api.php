<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;

/* Auth */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::get('/logout', [AuthController::class, 'logout']);

/* OAuth Google */
Route::get('/redirect', [AuthController::class, 'refresh']);
Route::get('/google/callback', [AuthController::class, 'callback']);

/* Category */
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('apps')->group(function () {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
    });
});
