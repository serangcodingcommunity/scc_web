<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\NarasumberController;
use App\Http\Controllers\PembayaranController;

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
Route::get('/events/narasumber', [NarasumberController::class, 'index'])->middleware('auth:sanctum');
Route::post('/events/narasumber', [NarasumberController::class, 'store'])->middleware('auth:sanctum');
Route::get('/events/narasumber/{id}', [NarasumberController::class, 'show'])->middleware('auth:sanctum');
Route::put('/events/narasumber/{id}', [NarasumberController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/events/narasumber/{id}', [NarasumberController::class, 'destroy'])->middleware('auth:sanctum');

/* Event */
Route::get('/events', [EventController::class, 'index'])->middleware('auth:sanctum');
Route::post('/events', [EventController::class, 'store'])->middleware('auth:sanctum');
Route::get('/events/{id}', [EventController::class, 'show'])->middleware('auth:sanctum');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth:sanctum');
Route::patch('/events/{id}', [EventController::class, 'publish'])->middleware('auth:sanctum');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth:sanctum');
Route::put('/events/{id}/tersedia', [EventController::class, 'tersediaEvent'])->middleware('auth:sanctum');
Route::put('/events/{id}/selesai', [EventController::class, 'selesaiEvent'])->middleware('auth:sanctum');

/* Event Registration */
Route::get('/event/registration', [EventRegistrationController::class, 'index'])->middleware('auth:sanctum');
Route::post('/event/registration', [EventRegistrationController::class, 'store'])->middleware('auth:sanctum');
Route::get('/event/registration/{id}', [EventRegistrationController::class, 'show'])->middleware('auth:sanctum');
Route::delete('/event/registration/{id}', [EventRegistrationController::class, 'destroy'])->middleware('auth:sanctum');
Route::put('/event/registration/{id}/payment', [EventRegistrationController::class, 'bayar'])->middleware('auth:sanctum');
Route::put('/event/registration/{id}/accept', [EventRegistrationController::class, 'accept'])->middleware('auth:sanctum');
Route::put('/event/registration/{id}/reject', [EventRegistrationController::class, 'reject'])->middleware('auth:sanctum');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('apps')->group(function () {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
    });
});
