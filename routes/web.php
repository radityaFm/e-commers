<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Cart_item;
use App\Http\Controllers\addToCart;
use App\Http\Controllers\OrderController;


//  Route untuk landing page (bisa diakses tanpa login)
Route::get('/', [LandingPageController::class, 'index'])->name('/');
// Route::get('admin', [AuthController::class, 'login'])->name('adminPanelProvider');

// Route untuk auth (login, register, logout)
Route::middleware(['guest'])->group(function(){
    Route::get('login', [AuthController::class, 'show'])->name('login');
    Route::post('auth.login', [AuthController::class, 'login'])->name('auth.login.submit');
    Route::get('auth/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('auth.register', [AuthController::class, 'register'])->name('register.process');
});
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Route untuk profile (harus login)
Route::middleware(['auth'])->group(function () {
    Route::get('account/profile', [ProfileController::class, 'show'])->name('account.profile');
    Route::get('account/editprofile', [ProfileController::class, 'edit'])->name('account.editprofile');
    Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update');
    Route::post('/profil/update/username', [ProfileController::class, 'updateUsername'])->name('profil.update.username');
    Route::post('/profil/update/password', [ProfileController::class, 'updatePassword'])->name('profil.update.password');
    Route::post('/profil/update/photo', [ProfileController::class, 'updatePhoto'])->name('profil.update.photo');
    Route::delete('/profil/delete', [ProfileController::class, 'deleteAccount'])->name('profil.delete');
});

// Route untuk product (bisa diakses tanpa login)
Route::get('user.product', [ProductController::class, 'show'])->name('user.product');

// Route untuk cart dan purchase (harus login)
Route::middleware(['auth'])->group(function () {
    Route::post('/user/product/add-to-cart', [CartController::class, 'addToCart'])->name('user.cart.add');
    Route::get('purchase/{id}/{quantity}', [ProductController::class, 'purchase'])->name('user.purchase');
    Route::post('/cart/updateCart/{id}', [CartController::class, 'updateCart'])->name('cart.updateCart');
    Route::get('cart', [CartController::class, 'viewCart'])->name('cart');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeCart'])->name('cart.removeCart');
    Route::post('cart.checkout', [CartController::class, 'checkout'])->name('checkout');
});

Route::get('order/histori', [OrderController::class, 'histori'])->name('order.histori');
Route::post('order/histori', [OrderController::class, 'checkout'])->name('order.histori');

// Route::resource('transaction-items', TransactionItemController::class);
// Route::middleware('auth')->group(function () {
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
//     Route::delete('/cart/{id}', [CartController::class, 'removeCart'])->name('cart.removeCart');
// });


