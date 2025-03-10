<?php

use App\Http\Controllers\Api\JwtController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile/{id}', [AuthController::class, 'getProfile']);
    Route::post('/update-profile/{id}', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::get('/token', [JwtController::class, 'createToken']);
Route::get('/removeToken', [JwtController::class, 'removeToken']);

Route::apiResource('products', ProductController::class)->middleware(JwtTokenMiddleware::class);
