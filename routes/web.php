<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;


Route::post('/register', [UserController::class, 'store']);
Route::get('/categories',[CategoryController::class, 'index']);
Route::get('/', function () {
    return view('welcome');
});
