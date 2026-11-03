<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalOrderController;
use App\Http\Controllers\ServiceInquiryController;
use Illuminate\Support\Facades\Route;

// Public Front Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Form Submissions with Rate Limiting (Anti-Spam: max 10 requests / minute)
Route::post('/rental/order', [RentalOrderController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('rental.order');

Route::post('/service/inquiry', [ServiceInquiryController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('service.inquiry');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Dashboard Routes (Requires Authenticated Session)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::get('/orders/{order}/invoice', [AdminController::class, 'printInvoice'])->name('orders.invoice');
    Route::patch('/inquiries/{inquiry}/status', [AdminController::class, 'updateInquiryStatus'])->name('inquiries.update-status');
    Route::patch('/items/{item}/toggle', [AdminController::class, 'toggleItemAvailability'])->name('items.toggle');
});
