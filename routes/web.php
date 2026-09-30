<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public landing
Route::get('/', [HomeController::class, 'index'])->name('home');

// Isolated single-section render — used by the admin Section Design Studio preview
Route::get('/preview/section/{section}', [HomeController::class, 'previewSection'])->name('preview.section');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Public order tracking
Route::get('/track', [OrderController::class, 'track'])->name('track');
Route::get('/order/track-json', [OrderController::class, 'trackJson'])->name('order.track.json');

// Legal pages (footer)
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-and-conditions', [HomeController::class, 'terms'])->name('terms');

// Public complaint submit (landing modal, fetch JSON)
Route::post('/complaint-store', [ComplaintController::class, 'store'])->name('complaint.store');

// Public SEO files
Route::get('/robots.txt', [Admin\SeoController::class, 'robotsTxt'])->name('robots.txt');
Route::get('/sitemap.xml', [Admin\SitemapController::class, 'xml'])->name('sitemap.xml');

// Orders
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{code}', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/invoice/{code}', [OrderController::class, 'invoice'])->name('order.invoice');

// Payment gateway return callbacks (bKash / Nagad redirect back here)
Route::get('/payment/callback/bkash/{code}', [\App\Http\Controllers\PaymentController::class, 'bkashCallback'])->name('payment.callback.bkash');
Route::get('/payment/callback/nagad/{code}', [\App\Http\Controllers\PaymentController::class, 'nagadCallback'])->name('payment.callback.nagad');

// Admin auth
Route::get('/admin/login', [Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.attempt');
Route::post('/admin/logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');

// Admin (protected)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/orders', [Admin\OrderController::class, 'index'])->middleware('perm:orders')->name('admin.orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->middleware('perm:orders')->name('admin.orders.show');
    Route::post('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->middleware('perm:orders')->name('admin.orders.status');
    Route::post('/orders/{order}/payment', [Admin\OrderController::class, 'updatePaymentStatus'])->middleware('perm:orders')->name('admin.orders.payment');
    Route::delete('/orders/{order}', [Admin\OrderController::class, 'destroy'])->middleware('perm:orders')->name('admin.orders.destroy');

    Route::get('/complaints', [Admin\ComplaintController::class, 'index'])->middleware('perm:complaints')->name('admin.complaints');
    Route::post('/complaints/{complaint}/toggle', [Admin\ComplaintController::class, 'toggle'])->middleware('perm:complaints')->name('admin.complaints.toggle');
    Route::delete('/complaints/{complaint}', [Admin\ComplaintController::class, 'destroy'])->middleware('perm:complaints')->name('admin.complaints.destroy');

    // customers (derived from orders) — search + rename + delete
    Route::get('/customers', [Admin\CustomerController::class, 'index'])->middleware('perm:customers')->name('admin.customers');
    Route::get('/customers/export/{type}', [Admin\CustomerController::class, 'export'])
        ->where('type', 'pdf|csv')->middleware('perm:customers')->name('admin.customers.export');
    Route::post('/customers/rename', [Admin\CustomerController::class, 'rename'])->middleware('perm:customers')->name('admin.customers.rename');
    Route::delete('/customers/{phone}', [Admin\CustomerController::class, 'destroy'])
        ->where('phone', '[0-9]+')->middleware('perm:customers')->name('admin.customers.destroy');

    // suppliers + purchase history
    Route::get('/suppliers', [Admin\SupplierController::class, 'index'])->middleware('perm:suppliers')->name('admin.suppliers');
    Route::post('/suppliers', [Admin\SupplierController::class, 'store'])->middleware('perm:suppliers')->name('admin.suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [Admin\SupplierController::class, 'edit'])->middleware('perm:suppliers')->name('admin.suppliers.edit');
    Route::get('/suppliers/{supplier}', [Admin\SupplierController::class, 'show'])->middleware('perm:suppliers')->name('admin.suppliers.show');
    Route::post('/suppliers/{supplier}', [Admin\SupplierController::class, 'update'])->middleware('perm:suppliers')->name('admin.suppliers.update');
    Route::post('/suppliers/{supplier}/toggle', [Admin\SupplierController::class, 'toggle'])->middleware('perm:suppliers')->name('admin.suppliers.toggle');
    Route::delete('/suppliers/{supplier}', [Admin\SupplierController::class, 'destroy'])->middleware('perm:suppliers')->name('admin.suppliers.destroy');
    Route::post('/suppliers/{supplier}/purchases', [Admin\SupplierController::class, 'storePurchase'])->middleware('perm:suppliers')->name('admin.suppliers.purchases.store');
    Route::delete('/purchases/{purchase}', [Admin\SupplierController::class, 'destroyPurchase'])->middleware('perm:suppliers')->name('admin.purchases.destroy');

    Route::get('/coupons', [Admin\CouponController::class, 'index'])->middleware('perm:coupons')->name('admin.coupons');
    Route::post('/coupons', [Admin\CouponController::class, 'store'])->middleware('perm:coupons')->name('admin.coupons.store');
    Route::post('/coupons/{coupon}', [Admin\CouponController::class, 'update'])->middleware('perm:coupons')->name('admin.coupons.update');
    Route::post('/coupons/{coupon}/toggle', [Admin\CouponController::class, 'toggle'])->middleware('perm:coupons')->name('admin.coupons.toggle');
    Route::delete('/coupons/{coupon}', [Admin\CouponController::class, 'destroy'])->middleware('perm:coupons')->name('admin.coupons.destroy');
    Route::get('/reviews', [Admin\ReviewController::class, 'index'])->middleware('perm:reviews')->name('admin.reviews');
    Route::post('/reviews', [Admin\ReviewController::class, 'save'])->middleware('perm:reviews')->name('admin.reviews.save');
    Route::get('/products', [Admin\ProductController::class, 'index'])->middleware('perm:products')->name('admin.products.index');
    Route::get('/products/create', [Admin\ProductController::class, 'create'])->middleware('perm:products')->name('admin.products.create');
    Route::post('/products', [Admin\ProductController::class, 'store'])->middleware('perm:products')->name('admin.products.store');
    Route::get('/products/{product}', [Admin\ProductController::class, 'show'])->middleware('perm:products')->name('admin.products.show');
    Route::get('/products/{product}/edit', [Admin\ProductController::class, 'edit'])->middleware('perm:products')->name('admin.products.edit');
    Route::put('/products/{product}', [Admin\ProductController::class, 'update'])->middleware('perm:products')->name('admin.products.update');
    Route::post('/products/{product}/toggle', [Admin\ProductController::class, 'toggle'])->middleware('perm:products')->name('admin.products.toggle');
    Route::delete('/products/{product}', [Admin\ProductController::class, 'destroy'])->middleware('perm:products')->name('admin.products.destroy');

    Route::get('/taxonomy', [Admin\TaxonomyController::class, 'index'])->middleware('perm:taxonomy')->name('admin.taxonomy');
    Route::get('/modules/{module}', [Admin\ModuleController::class, 'show'])->name('admin.module');
    Route::post('/taxonomy/category', [Admin\TaxonomyController::class, 'storeCategory'])->middleware('perm:taxonomy')->name('admin.taxonomy.category.store');
    Route::post('/taxonomy/category/{category}/toggle', [Admin\TaxonomyController::class, 'toggleCategory'])->middleware('perm:taxonomy')->name('admin.taxonomy.category.toggle');
    Route::delete('/taxonomy/category/{category}', [Admin\TaxonomyController::class, 'destroyCategory'])->middleware('perm:taxonomy')->name('admin.taxonomy.category.destroy');
    Route::post('/taxonomy/brand', [Admin\TaxonomyController::class, 'storeBrand'])->middleware('perm:taxonomy')->name('admin.taxonomy.brand.store');
    Route::post('/taxonomy/brand/{brand}/toggle', [Admin\TaxonomyController::class, 'toggleBrand'])->middleware('perm:taxonomy')->name('admin.taxonomy.brand.toggle');
    Route::delete('/taxonomy/brand/{brand}', [Admin\TaxonomyController::class, 'destroyBrand'])->middleware('perm:taxonomy')->name('admin.taxonomy.brand.destroy');

    Route::get('/settings/brand', [Admin\SettingController::class, 'brand'])->middleware('perm:brand')->name('admin.settings.brand');
    Route::post('/settings/brand', [Admin\SettingController::class, 'saveBrand'])->middleware('perm:brand')->name('admin.settings.brand.save');
    Route::get('/settings/theme', [Admin\SettingController::class, 'theme'])->middleware('perm:theme')->name('admin.settings.theme');
    Route::post('/settings/theme', [Admin\SettingController::class, 'saveTheme'])->middleware('perm:theme')->name('admin.settings.theme.save');
    Route::post('/settings/theme/custom', [Admin\SettingController::class, 'saveCustomTheme'])->middleware('perm:theme')->name('admin.settings.theme.custom');
    Route::post('/settings/theme/reset', [Admin\SettingController::class, 'resetTheme'])->middleware('perm:theme')->name('admin.settings.theme.reset');
    Route::post('/settings/theme/my-theme', [Admin\SettingController::class, 'saveMyTheme'])->middleware('perm:theme')->name('admin.settings.theme.my.save');
    Route::post('/settings/theme/my-theme/delete', [Admin\SettingController::class, 'deleteMyTheme'])->middleware('perm:theme')->name('admin.settings.theme.my.delete');
    Route::post('/settings/theme/history-restore', [Admin\SettingController::class, 'restoreHistory'])->middleware('perm:theme')->name('admin.settings.theme.history.restore');
    Route::post('/settings/theme/fonts', [Admin\SettingController::class, 'saveFonts'])->middleware('perm:theme')->name('admin.settings.theme.fonts');
    Route::post('/settings/theme/style', [Admin\SettingController::class, 'saveStyle'])->middleware('perm:theme')->name('admin.settings.theme.style');
    Route::post('/settings/theme/festive', [Admin\SettingController::class, 'saveFestive'])->middleware('perm:theme')->name('admin.settings.theme.festive');
    Route::get('/settings/delivery', [Admin\SettingController::class, 'delivery'])->middleware('perm:delivery')->name('admin.settings.delivery');
    Route::post('/settings/delivery', [Admin\SettingController::class, 'saveDelivery'])->middleware('perm:delivery')->name('admin.settings.delivery.save');
    Route::get('/settings/content', [Admin\SettingController::class, 'content'])->middleware('perm:content')->name('admin.settings.content');
    Route::post('/settings/content', [Admin\SettingController::class, 'saveContent'])->middleware('perm:content')->name('admin.settings.content.save');
    Route::get('/settings/sections', [Admin\SettingController::class, 'sections'])->middleware('perm:sections')->name('admin.settings.sections');
    Route::post('/settings/industry', [Admin\SettingController::class, 'applyIndustry'])->middleware('perm:sections')->name('admin.settings.industry.apply');
    Route::post('/settings/industry/clear', [Admin\SettingController::class, 'clearIndustry'])->middleware('perm:sections')->name('admin.settings.industry.clear');
    Route::post('/settings/sections', [Admin\SettingController::class, 'saveSections'])->middleware('perm:sections')->name('admin.settings.sections.save');
    Route::get('/settings/tracking', [Admin\SettingController::class, 'tracking'])->middleware('perm:tracking')->name('admin.settings.tracking');
    Route::post('/settings/tracking/{key}', [Admin\SettingController::class, 'saveTracking'])->middleware('perm:tracking')->name('admin.settings.tracking.save');
    Route::get('/settings/payment', [Admin\SettingController::class, 'payment'])->middleware('perm:payment')->name('admin.settings.payment');
    Route::post('/settings/payment', [Admin\SettingController::class, 'savePayment'])->middleware('perm:payment')->name('admin.settings.payment.save');
    Route::get('/seo', [Admin\SeoController::class, 'index'])->middleware('perm:seo')->name('admin.seo');
    Route::post('/seo', [Admin\SeoController::class, 'save'])->middleware('perm:seo')->name('admin.seo.save');
    Route::get('/robots', [Admin\SeoController::class, 'robotsPage'])->middleware('perm:robots')->name('admin.robots');
    Route::post('/robots', [Admin\SeoController::class, 'saveRobots'])->middleware('perm:robots')->name('admin.robots.save');
    Route::get('/redirects', [Admin\RedirectController::class, 'index'])->middleware('perm:redirects')->name('admin.redirects.index');
    Route::post('/redirects', [Admin\RedirectController::class, 'store'])->middleware('perm:redirects')->name('admin.redirects.store');
    Route::post('/redirects/{redirect}/toggle', [Admin\RedirectController::class, 'toggle'])->middleware('perm:redirects')->name('admin.redirects.toggle');
    Route::delete('/redirects/{redirect}', [Admin\RedirectController::class, 'destroy'])->middleware('perm:redirects')->name('admin.redirects.destroy');
    Route::get('/sitemap', [Admin\SitemapController::class, 'page'])->middleware('perm:sitemap')->name('admin.sitemap');
    Route::post('/sitemap/urls', [Admin\SitemapController::class, 'store'])->middleware('perm:sitemap')->name('admin.sitemap.store');
    Route::post('/sitemap/urls/{url}/toggle', [Admin\SitemapController::class, 'toggle'])->middleware('perm:sitemap')->name('admin.sitemap.toggle');
    Route::delete('/sitemap/urls/{url}', [Admin\SitemapController::class, 'destroy'])->middleware('perm:sitemap')->name('admin.sitemap.destroy');

    // admin management — list, create, edit permissions, remove admin logins
    Route::get('/admin-management', [Admin\AdminManagerController::class, 'index'])->middleware('perm:admins')->name('admin.admins.index');
    Route::post('/admin-management', [Admin\AdminManagerController::class, 'store'])->middleware('perm:admins')->name('admin.admins.store');
    Route::put('/admin-management/{user}', [Admin\AdminManagerController::class, 'update'])->middleware('perm:admins')->name('admin.admins.update');
    Route::delete('/admin-management/{user}', [Admin\AdminManagerController::class, 'destroy'])
        ->middleware('perm:admins')->name('admin.admins.destroy');

    // আমার অ্যাকাউন্ট — self service (nijer password change), sob admin er jonno
    Route::get('/account', [Admin\AccountController::class, 'index'])->name('admin.account');
    Route::post('/account/password', [Admin\AccountController::class, 'changePassword'])->name('admin.account.password');

    // notification bell: mark everything as read
    Route::post('/notifications/read-all', function () {
        \App\Models\OrderNotification::where('is_read', false)->update(['is_read' => true]);
        return back();
    })->name('admin.notifications.readAll');
});
