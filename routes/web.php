<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountUserController;
use App\Http\Controllers\ProfileController;

Route::get('landingpage', [LandingPageController::class, 'index'])->name('landingpage'); // Halaman Landing

Route::get('auth.login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('auth.login', [AuthController::class, 'login'])->name('login.process');
Route::get('auth.register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('auth.register', [AuthController::class, 'register'])->name('register.process');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/order', [OrderController::class, 'index'])->name('order.index');


    Route::get('/account/profile', [ProfileController::class, 'index'])->name('account.profile');
    // Route::get('account.profile', [AccountUserController::class, 'index'])->name('account.profile');
    Route::post('/profile/update-username', [AccountUserController::class, 'updateUsername'])->name('profile.update.username');
    Route::post('/profile/update-password', [AccountUserController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/update-photo', [AccountUserController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::post('/profile/delete-account', [AccountUserController::class, 'deleteAccount'])->name('profile.delete');
