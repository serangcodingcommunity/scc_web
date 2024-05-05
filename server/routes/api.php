<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\NarasumberController;

/* Auth */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
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

/* Narasumber */
Route::post('/events/narasumber', [NarasumberController::class, 'store'])->middleware('auth:sanctum');

/* Event */
Route::get('/events', [EventController::class, 'index'])->middleware('auth:sanctum');
Route::post('/events', [EventController::class, 'store'])->middleware('auth:sanctum');
Route::get('/events/{id}', [EventController::class, 'show'])->middleware('auth:sanctum');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth:sanctum');
Route::patch('/events/{id}', [EventController::class, 'patch'])->middleware('auth:sanctum');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth:sanctum');

/* Pembayaran */

/* Event Registration */
Route::get('/event/registration', [EventRegistrationController::class, 'index'])->middleware('auth:sanctum');
Route::post('/event/registration', [EventRegistrationController::class, 'store'])->middleware('auth:sanctum');
Route::get('/event/registration/{id}', [EventRegistrationController::class, 'show'])->middleware('auth:sanctum');
Route::delete('/event/registration/{id}', [EventRegistrationController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('apps')->group(function () {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
    });
});
