<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminUserController;

Route::get('/', [CatalogController::class, 'index'])->name('index');
Route::get('/book/{book}', [CatalogController::class, 'show'])->name('book.show');

// Test route to verify routing is working
Route::get('/test-route', function () {
    return response()->json(['message' => 'Routes are working correctly!']);
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes - Protected by auth middleware
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Profile management
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Book management - accessible by both user and admin
    // Additional book management routes (must be before resource routes)
    Route::get('/books/export/csv', [AdminBookController::class, 'exportCsv'])->name('books.export.csv');
    Route::post('/books/train-recommendation', [AdminBookController::class, 'trainRecommendationSystem'])->name('books.train.recommendation');
    Route::get('/books/test-fastapi', [AdminBookController::class, 'testFastApiConnection'])->name('books.test.fastapi');

    Route::resource('books', AdminBookController::class);

    // User management - only accessible by admin
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', AdminUserController::class);
    });
});

// Route::get('/', function () {
//     return view('welcome');
// });
