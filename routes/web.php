<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Shared Download & View Routes
    Route::get('/sk/{id}/download', [\App\Http\Controllers\PolicyController::class, 'download'])->name('sk.download');
    Route::get('/sk/{id}/view', [\App\Http\Controllers\PolicyController::class, 'viewFile'])->name('sk.view');
    Route::get('/pojk/{id}/download', [\App\Http\Controllers\PojkController::class, 'download'])->name('pojk.download');
    Route::get('/pojk/{id}/view', [\App\Http\Controllers\PojkController::class, 'viewFile'])->name('pojk.view');
    Route::get('/pks/{id}/download', [\App\Http\Controllers\PksController::class, 'download'])->name('pks.download');
    Route::get('/pks/{id}/view', [\App\Http\Controllers\PksController::class, 'viewFile'])->name('pks.view');

    // Admin Routes
    Route::middleware([RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/sk', [AdminController::class, 'sk'])->name('sk');
        Route::post('/sk', [AdminController::class, 'storeSk'])->name('sk.store');
        Route::put('/sk/{id}', [AdminController::class, 'updateSk'])->name('sk.update');
        Route::delete('/sk/{id}', [AdminController::class, 'destroySk'])->name('sk.destroy');

        Route::get('/pojk', [AdminController::class, 'pojk'])->name('pojk');
        Route::post('/pojk', [AdminController::class, 'storePojk'])->name('pojk.store');
        Route::put('/pojk/{id}', [AdminController::class, 'updatePojk'])->name('pojk.update');
        Route::delete('/pojk/{id}', [AdminController::class, 'destroyPojk'])->name('pojk.destroy');

        Route::get('/pks', [AdminController::class, 'pks'])->name('pks');
        Route::post('/pks', [AdminController::class, 'storePks'])->name('pks.store');
        Route::put('/pks/{id}', [AdminController::class, 'updatePks'])->name('pks.update');
        Route::delete('/pks/{id}', [AdminController::class, 'destroyPks'])->name('pks.destroy');

        Route::get('/video', [AdminController::class, 'video'])->name('video');
        Route::post('/video', [AdminController::class, 'storeVideo'])->name('video.store');
        Route::put('/video/{id}', [AdminController::class, 'updateVideo'])->name('video.update');
        Route::delete('/video/{id}', [AdminController::class, 'destroyVideo'])->name('video.destroy');
        
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

    // User Routes
    Route::middleware([RoleMiddleware::class . ':user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', function() { return redirect()->route('user.sk'); })->name('dashboard');
        Route::get('/sk', [UserController::class, 'sk'])->name('sk');
        Route::get('/pojk', [UserController::class, 'pojk'])->name('pojk');
        Route::get('/pks', [UserController::class, 'pks'])->name('pks');
        Route::get('/video', [UserController::class, 'video'])->name('video');
        
        // Profile Routes (User only)
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    });
});
