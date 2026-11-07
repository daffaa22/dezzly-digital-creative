<?php

use App\Http\Controllers\Admin\ChatAdminController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
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

// Live Negotiation Chat API (Visitor Side)
Route::prefix('chat')->name('chat.')->group(function () {
    Route::post('/start', [ChatController::class, 'startSession'])->middleware('throttle:15,1')->name('start');
    Route::get('/{token}', [ChatController::class, 'getSession'])->name('get');
    Route::get('/{token}/poll', [ChatController::class, 'pollMessages'])->name('poll');
    Route::post('/{token}/send', [ChatController::class, 'sendMessage'])->middleware('throttle:60,1')->name('send');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Dashboard & CMS Routes (Requires Authenticated Session)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 1. Operasional: Orders & Inquiries
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::get('/orders/{order}/invoice', [AdminController::class, 'printInvoice'])->name('orders.invoice');
    Route::patch('/inquiries/{inquiry}/status', [AdminController::class, 'updateInquiryStatus'])->name('inquiries.update-status');
    Route::patch('/items/{item}/toggle', [AdminController::class, 'toggleItemAvailability'])->name('items.toggle');

    // 2. Ruang Negosiasi Chat Realtime
    Route::get('/chats', [ChatAdminController::class, 'index'])->name('chats.index');
    Route::get('/chats/sessions', [ChatAdminController::class, 'getSessions'])->name('chats.sessions');
    Route::get('/chats/{session}/messages', [ChatAdminController::class, 'getMessages'])->name('chats.messages');
    Route::post('/chats/{session}/messages', [ChatAdminController::class, 'sendMessage'])->name('chats.send');
    Route::post('/chats/{session}/deal', [ChatAdminController::class, 'markDeal'])->name('chats.deal');
    Route::delete('/chats/{session}', [ChatAdminController::class, 'destroy'])->name('chats.destroy');
    Route::post('/chats/prune-expired', [ChatAdminController::class, 'pruneExpired'])->name('chats.prune');

    // 2. CMS: Pengaturan Landing Page & Profil Studio
    Route::get('/cms/settings', [CmsController::class, 'indexSettings'])->name('cms.settings');
    Route::put('/cms/settings', [CmsController::class, 'updateSettings'])->name('cms.settings.update');

    // 3. CMS: Paket Dokumentasi
    Route::get('/cms/packages', [CmsController::class, 'indexPackages'])->name('cms.packages');
    Route::post('/cms/packages', [CmsController::class, 'storePackage'])->name('cms.packages.store');
    Route::put('/cms/packages/{package}', [CmsController::class, 'updatePackage'])->name('cms.packages.update');
    Route::delete('/cms/packages/{package}', [CmsController::class, 'deletePackage'])->name('cms.packages.delete');
    Route::patch('/cms/packages/{package}/toggle', [CmsController::class, 'togglePackage'])->name('cms.packages.toggle');

    // 4. CMS: Unit Rental Kamera & Lensa
    Route::get('/cms/rental-items', [CmsController::class, 'indexRentalItems'])->name('cms.rental-items');
    Route::post('/cms/rental-items', [CmsController::class, 'storeRentalItem'])->name('cms.rental-items.store');
    Route::put('/cms/rental-items/{item}', [CmsController::class, 'updateRentalItem'])->name('cms.rental-items.update');
    Route::delete('/cms/rental-items/{item}', [CmsController::class, 'deleteRentalItem'])->name('cms.rental-items.delete');
    Route::patch('/cms/rental-items/{item}/toggle', [CmsController::class, 'toggleRentalItem'])->name('cms.rental-items.toggle');

    // 5. CMS: Portofolio & Karya
    Route::get('/cms/portfolio', [CmsController::class, 'indexPortfolios'])->name('cms.portfolio');
    Route::post('/cms/portfolio', [CmsController::class, 'storePortfolio'])->name('cms.portfolio.store');
    Route::put('/cms/portfolio/{portfolio}', [CmsController::class, 'updatePortfolio'])->name('cms.portfolio.update');
    Route::delete('/cms/portfolio/{portfolio}', [CmsController::class, 'deletePortfolio'])->name('cms.portfolio.delete');

    // 6. CMS: FAQ Pengunjung
    Route::get('/cms/faqs', [CmsController::class, 'indexFaqs'])->name('cms.faqs');
    Route::post('/cms/faqs', [CmsController::class, 'storeFaq'])->name('cms.faqs.store');
    Route::put('/cms/faqs/{faq}', [CmsController::class, 'updateFaq'])->name('cms.faqs.update');
    Route::delete('/cms/faqs/{faq}', [CmsController::class, 'deleteFaq'])->name('cms.faqs.delete');
    Route::patch('/cms/faqs/{faq}/toggle', [CmsController::class, 'toggleFaq'])->name('cms.faqs.toggle');
});
