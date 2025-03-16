<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaystationController;

// Route::get('/', function () {
//     return view('admin.dashboard.index');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [LayoutsController::class, 'index'])->name('index');
Route::get('/bookings/events', [BookingController::class, 'getEvents'])->name('bookings.events');

Route::middleware('auth')->group(function () {
    //get playsation data
    Route::get('/playstations/list', [PlaystationController::class, 'list'])->name('playstations.list'); 

    // booking oleh customer
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
   

    // payment midtrans
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/update-status/{id}', [PaymentController::class, 'UpdateStatus'])->name('payment.updateStatus');
    Route::get('/booking/confirm/{id}', [BookingController::class, 'confirm'])
    ->name('booking.confirm');

    



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-pages/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // playstation routes
    Route::get('/admin-pages/playstation-get', [PlaystationController::class, 'index'])->name('admin.playstation');
    Route::post('/admin-pages/playstation-store', [PlaystationController::class, 'store'])->name('admin.playstation.store');
    Route::patch('/admin-pages/playstation-update/{id}', [PlaystationController::class, 'update'])->name('admin.playstation.update');
    Route::delete('/admin-pages/playstation-destroy/{id}', [PlaystationController::class, 'destroy'])->name('admin.playstation.destroy');

    // booking routes
    Route::get('/admin-pages/booking-get', [BookingController::class, 'index'])->name('admin.booking');
});


require __DIR__.'/auth.php';
