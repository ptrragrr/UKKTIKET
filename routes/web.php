<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PilihTiketController;
use App\Http\Controllers\MitransController;
use App\Http\Controllers\PaymentController;

// ====================
// PUBLIC ROUTES
// ====================
Route::view('/', 'users.home')->name('home');
Route::get('/tickets', [PilihTiketController::class, 'index'])->name('tickets'); // ✅ ambil dari controller
Route::view('/about', 'users.about')->name('about');
Route::view('/contact', 'users.contact')->name('contact');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.page');
// Route::get('/checkout', [OrderController::class, 'index'])->name('checkout.page');
Route::post('/checkout', [CheckoutController::class, 'storeGuest'])->name('transaksi.guest.store');
Route::post('/checkout/snap', [CheckoutController::class, 'createCharge']);
Route::get('/checkout/{konserId}', [CheckoutController::class, 'showCheckout']);
// Route::post('/pay', [CheckoutController::class, 'pay']); 
// Route::post('/transaksi/update-status', [CheckoutController::class, 'updateStatus']);
// Route::post('/checkout/pay', [CheckoutController::class, 'payWithXendit'])->name('checkout.pay');
// Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
// Route::get('/checkout/failed', [CheckoutController::class, 'failed'])->name('checkout.failed');
// Route::get('/checkout', function() {
//     return view('checkout');
// })->name('checkout.show');


Route::post('/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::post('/midtrans/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');

Route::post('/payment/create', [PaymentController::class, 'createTransaction']);
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler']);
Route::post('/transaksi/update-status', [CheckoutController::class, 'updateStatus'])->name('transaksi.updateStatus');


// ====================
// NON-AUTH Routes (hapus auth middleware karena tidak pakai login)
// ====================
Route::view('/dashboard', 'users.dashboard')->name('dashboard');
Route::view('/order', 'users.pesan')->name('order');
