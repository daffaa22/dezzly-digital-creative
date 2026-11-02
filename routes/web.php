<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalOrderController;
use App\Http\Controllers\ServiceInquiryController;
use Illuminate\Support\Facades\Route;

// Public Front Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/rental/order', [RentalOrderController::class, 'store'])->name('rental.order');
Route::post('/service/inquiry', [ServiceInquiryController::class, 'store'])->name('service.inquiry');

// Admin Dashboard Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::patch('/inquiries/{inquiry}/status', [AdminController::class, 'updateInquiryStatus'])->name('inquiries.update-status');
    Route::patch('/items/{item}/toggle', [AdminController::class, 'toggleItemAvailability'])->name('items.toggle');
});
