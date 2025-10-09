<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;



use App\Models\Category;

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::post('logout', [AuthController::class, 'logouts']);
    // Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::apiResource('users', UserController::class);
});
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class);
