<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

Route::get('/', [LandingPageController::class, 'index'])->name('landingpage'); 

Route::middleware('guest')->group(function(){
    Route::get('auth.login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('auth.login', [AuthController::class, 'login'])->name('login.process');
    Route::get('auth.register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('auth.register', [AuthController::class, 'register'])->name('register.process'); 
});
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/order', [OrderController::class, 'index'])->name('order.index');

   
Route::middleware('auth')->group(function () {
    Route::get('account.profile', [ProfileController::class, 'show'])->name('account.profile'); // Halaman profil utama
    Route::get('account.editprofile', [ProfileController::class, 'edit'])->name('account.editprofile'); // Form edit profil
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update'); // Proses update profil
    // Additional routes for updating username, password, and photo
    Route::post('/profil/update/username', [ProfileController::class, 'updateUsername'])->name('profil.update.username');
    Route::post('/profil/update/password', [ProfileController::class, 'updatePassword'])->name('profil.update.password');
    Route::post('/profil/update/photo', [ProfileController::class, 'updatePhoto'])->name('profil.update.photo');
    // Route to delete account
    Route::delete('/profil/delete', [ProfileController::class, 'deleteAccount'])->name('profil.delete');
});

Route::get('user.product', [ProductController::class, 'show'])->name('user.product');
Route::get('purchase/{id}/{quantity}', [ProductController::class, 'purchase'])->name('user.purchase');