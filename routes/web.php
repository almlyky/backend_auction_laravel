<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

// Route::post('/register', [UserController::class, 'store']);
// Route::get('/categories',[CategoryController::class, 'index']);
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::get('/reports/{id}', [AdminController::class, 'reportDetails'])->name('reports.show');
    Route::put('/reports/{id}/status', [AdminController::class, 'updateReportStatus'])->name('reports.update_status');
    Route::post('/users/{id}/toggle-block', [AdminController::class, 'toggleUserBlock'])->name('users.toggle_block');
    
    Route::get('/users', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [\App\Http\Controllers\AdminUserController::class, 'show'])->name('users.show');

    Route::get('/posts', [\App\Http\Controllers\AdminPostController::class, 'index'])->name('posts.index');
    Route::post('/posts/{id}/restore', [\App\Http\Controllers\AdminPostController::class, 'restore'])->name('posts.restore');
    Route::get('/posts/{id}', [AdminController::class, 'postDetails'])->name('posts.show');
    Route::delete('/posts/{id}', [AdminController::class, 'deletePost'])->name('posts.destroy');
});
