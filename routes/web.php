<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PilihTiketController;

// ====================
// PUBLIC ROUTES
// ====================
Route::view('/', 'users.home')->name('home');
Route::get('/tickets', [PilihTiketController::class, 'index'])->name('tickets'); // ✅ ambil dari controller
Route::view('/about', 'users.about')->name('about');
Route::view('/contact', 'users.contact')->name('contact');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.page');
Route::post('/checkout', [CheckoutController::class, 'storeGuest'])->name('transaksi.guest.store');
Route::get('/checkout', function() {
    return view('checkout');
})->name('checkout.show');

// ====================
// NON-AUTH Routes (hapus auth middleware karena tidak pakai login)
// ====================
Route::view('/dashboard', 'users.dashboard')->name('dashboard');
Route::view('/order', 'users.pesan')->name('order');
