<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Middleware\JwtMiddleware;



use App\Models\Category;
use App\Models\Favorite;

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::post('logout', [AuthController::class, 'logouts']);
    // Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('posts', PostController::class);
    Route::get('posts_by_user/{userId}',[PostController::class,'showPostByUser']);
    Route::apiResource('favorites', FavoriteController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('users', UserController::class);
});
Route::post('register', [UserController::class, 'store']);
Route::get('/verify/{token}', [AuthController::class, 'verifyPhone']);
Route::post('login', [AuthController::class, 'login']);
