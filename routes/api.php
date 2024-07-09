<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->middleware(['web'])->group(function () {
    Route::post('/register-user', [AuthController::class, 'registerUser'])->name('api.register-user');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('api.authenticate');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('api.showRegistrationForm');
    Route::post('/register', [AuthController::class, 'registerUser'])->name('api.register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/user-profile', [AuthController::class, 'getUserProfile'])->name('api.user-profile');
    Route::get('/user/profile', [UserController::class, 'profile']);
});

Route::get('/public-route', function () {
    return response()->json(['message' => 'This is a public route accessible to all']);
});

