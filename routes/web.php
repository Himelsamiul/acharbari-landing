<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public landing
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Orders
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{code}', [OrderController::class, 'success'])->name('order.success');

// Admin auth
Route::get('/admin/login', [Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.attempt');
Route::post('/admin/logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');

// Admin (protected)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('admin.orders.status');
    Route::delete('/orders/{order}', [Admin\OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/products', [Admin\ProductController::class, 'index'])->name('admin.products.index');
});
