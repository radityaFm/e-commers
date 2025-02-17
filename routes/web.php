<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItem;
use App\Http\Controllers\addToCart;
use App\Http\Controllers\ProductTransactionController;

// Route::get('/', [LandingPageController::class, 'index'])->name('landingpage'); 
Route::middleware(['auth'])->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');
});

Route::get('/home', function () {
    return view('landingpage'); // Sesuaikan dengan view dashboard user Anda
})->name('home');

Route::middleware(['guest'])->group(function(){
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login.submit'); // URI changed to 'login'
    Route::get('auth.register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('auth.register', [AuthController::class, 'register'])->name('register.process'); 
});
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

   
    Route::get('account.profile', [ProfileController::class, 'show'])->name('account.profile'); // Halaman profil utama
    Route::get('account.editprofile', [ProfileController::class, 'edit'])->name('account.editprofile'); // Form edit profil
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update'); // Proses update profil
    // Additional routes for updating username, password, and photo
    Route::post('/profil/update/username', [ProfileController::class, 'updateUsername'])->name('profil.update.username');
    Route::post('/profil/update/password', [ProfileController::class, 'updatePassword'])->name('profil.update.password');
    Route::post('/profil/update/photo', [ProfileController::class, 'updatePhoto'])->name('profil.update.photo');
    // Route to delete account
    Route::delete('/profil/delete', [ProfileController::class, 'deleteAccount'])->name('profil.delete');

            Route::get('user.product', [ProductController::class, 'show'])->name('user.product');
            Route::post('/user/product/add-to-cart', [CartController::class, 'addToCart'])->name('user.cart.add');
            Route::get('purchase/{id}/{quantity}', [ProductController::class, 'purchase'])->name('user.purchase');


Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart', [CartController::class, 'viewCart'])->name('cart');
Route::middleware('auth')->group(function () {
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeCart'])->name('cart.removeCart');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});


