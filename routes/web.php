<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FashionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PhotoController::class, 'index'])->name('fashion.index');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');
});

Route::post('/admin/logout', [AdminAuthController::class, 'destroy'])->name('admin.logout')->middleware('auth');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::delete('/admin/photos/{photo}', [AdminController::class, 'destroyPhoto'])->name('admin.photos.destroy');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Authenticated upload routes
    Route::get('/upload', [FashionController::class, 'upload'])->name('fashion.upload');
    Route::post('/photos', [FashionController::class, 'store'])->name('photos.store');
    Route::post('/photos/outfit', [FashionController::class, 'storeOutfit'])->name('photos.storeOutfit');
});

Route::controller(FashionController::class)->group(function () {
    Route::get('/gallery', 'gallery')->name('fashion.gallery');
    Route::get('/leaderboard', 'leaderboard')->name('fashion.leaderboard');
});

// Authenticated routes for liking
Route::middleware('auth')->group(function () {
    Route::post('/photos/{photo}/like', [FashionController::class, 'like'])->name('photos.like');
});

require __DIR__.'/auth.php';
