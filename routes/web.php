<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPhotoController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ─── Authentication ──────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── User Routes ─────────────────────────────────────────────────
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Gallery & Photos
    Route::get('/gallery',         [PhotoController::class, 'gallery'])->name('gallery');
    Route::get('/upload',          [PhotoController::class, 'showUpload'])->name('upload');
    Route::post('/upload',         [PhotoController::class, 'upload'])->name('upload.post');
    Route::get('/photo/{photo}',   [PhotoController::class, 'preview'])->name('photo.preview');
    Route::get('/download/{photo}',[PhotoController::class, 'download'])->name('download');
    Route::delete('/photo/{photo}',[PhotoController::class, 'destroy'])->name('photo.destroy');
});

// ─── Admin Routes ─────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',  [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Photos
    Route::get('/photos',            [AdminPhotoController::class, 'index'])->name('photos.index');
    Route::delete('/photos/{photo}', [AdminPhotoController::class, 'destroy'])->name('photos.destroy');
    Route::post('/photos/bulk-delete',[AdminPhotoController::class, 'bulkDestroy'])->name('photos.bulk-destroy');

    // Admin Users CRUD
    Route::get('/users',           [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create',    [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users',          [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit',[AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',    [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});
