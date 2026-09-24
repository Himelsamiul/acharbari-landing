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

// Public order tracking
Route::get('/track', [OrderController::class, 'track'])->name('track');

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
    Route::get('/products/create', [Admin\ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [Admin\ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [Admin\ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [Admin\ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/taxonomy', [Admin\TaxonomyController::class, 'index'])->name('admin.taxonomy');
    Route::post('/taxonomy/category', [Admin\TaxonomyController::class, 'storeCategory'])->name('admin.taxonomy.category.store');
    Route::delete('/taxonomy/category/{category}', [Admin\TaxonomyController::class, 'destroyCategory'])->name('admin.taxonomy.category.destroy');
    Route::post('/taxonomy/brand', [Admin\TaxonomyController::class, 'storeBrand'])->name('admin.taxonomy.brand.store');
    Route::delete('/taxonomy/brand/{brand}', [Admin\TaxonomyController::class, 'destroyBrand'])->name('admin.taxonomy.brand.destroy');

    Route::get('/settings/brand', [Admin\SettingController::class, 'brand'])->name('admin.settings.brand');
    Route::post('/settings/brand', [Admin\SettingController::class, 'saveBrand'])->name('admin.settings.brand.save');
    Route::get('/settings/theme', [Admin\SettingController::class, 'theme'])->name('admin.settings.theme');
    Route::post('/settings/theme', [Admin\SettingController::class, 'saveTheme'])->name('admin.settings.theme.save');
    Route::get('/settings/tracking/{key}', [Admin\SettingController::class, 'tracking'])->name('admin.settings.tracking')->whereIn('key', ['fb', 'ga', 'gtm', 'tiktok']);
    Route::post('/settings/tracking/{key}', [Admin\SettingController::class, 'saveTracking'])->name('admin.settings.tracking.save');
    Route::get('/seo', [Admin\SeoController::class, 'index'])->name('admin.seo');
    Route::post('/seo', [Admin\SeoController::class, 'save'])->name('admin.seo.save');
    Route::get('/sitemap', [Admin\SitemapController::class, 'page'])->name('admin.sitemap');
    Route::get('/sitemap.xml', [Admin\SitemapController::class, 'xml'])->name('admin.sitemap.xml');
});
