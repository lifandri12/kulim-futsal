<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [FieldController::class, 'index'])->name('home');

// Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Detail lapangan (bisa dilihat semua orang)
Route::get('/lapangan/{id}', [FieldController::class, 'show'])->name('fields.show');

/*
|--------------------------------------------------------------------------
| ROUTE USER (harus login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Booking
    Route::get('/booking/{id_field}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking/{id}/payment', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/booking/{id}/payment', [BookingController::class, 'processPayment'])->name('bookings.processPayment');
    Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('bookings.riwayat');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Review lapangan
    Route::post('/lapangan/{id}/review', [FieldController::class, 'storeReview'])->name('fields.review');
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (harus login sebagai admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Lapangan CRUD
    Route::get('/lapangan', [AdminController::class, 'fields'])->name('fields');
    Route::get('/lapangan/tambah', [AdminController::class, 'fieldCreate'])->name('fields.create');
    Route::post('/lapangan', [AdminController::class, 'fieldStore'])->name('fields.store');
    Route::get('/lapangan/{id}/edit', [AdminController::class, 'fieldEdit'])->name('fields.edit');
    Route::put('/lapangan/{id}', [AdminController::class, 'fieldUpdate'])->name('fields.update');
    Route::delete('/lapangan/{id}', [AdminController::class, 'fieldDelete'])->name('fields.delete');

    // Booking
    Route::get('/booking', [AdminController::class, 'bookings'])->name('bookings');
    Route::post('/booking/{id}/status', [AdminController::class, 'bookingUpdateStatus'])->name('bookings.status');

    // User
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'userDelete'])->name('users.delete');
});
