<?php

use App\Http\Controllers\Api\V1\CompleteTaskController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

// Route group for v1
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
    Route::post('/logout', LogoutController::class);
});

// Route get user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

