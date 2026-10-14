<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Public landing
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public landing-page showcase: design gallery (super admin sells designs)
// + per-genre live demos (their product carts create normal store orders)
Route::get('/showcase', [\App\Http\Controllers\ShowcaseController::class, 'index'])->name('showcase.index');
Route::get('/showcase/{genre}', [\App\Http\Controllers\ShowcaseController::class, 'demo'])->name('showcase.demo');

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

/* ================= Customer accounts (storefront) ================= */

Route::middleware('guest')->group(function () {
    Route::get('/register', [\App\Http\Controllers\Account\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Account\AuthController::class, 'register'])->name('register.attempt');
    Route::get('/login', [\App\Http\Controllers\Account\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Account\AuthController::class, 'login'])->name('login.attempt');

    // password reset — only meaningful for accounts that have an email
    Route::get('/forgot-password', [\App\Http\Controllers\Account\PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Account\PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Account\PasswordResetController::class, 'form'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Account\PasswordResetController::class, 'update'])->name('password.update');
});

Route::post('/logout', [\App\Http\Controllers\Account\AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

// Customer area: profile + my orders
Route::prefix('account')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Account\AccountController::class, 'profile'])->name('account');
    Route::post('/', [\App\Http\Controllers\Account\AccountController::class, 'update'])->name('account.update');
    Route::post('/password', [\App\Http\Controllers\Account\AccountController::class, 'updatePassword'])->name('account.password');
    Route::get('/orders', [\App\Http\Controllers\Account\AccountController::class, 'orders'])->name('account.orders');
});

/* ================= Admin auth ================= */

Route::get('/admin/login', [Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.attempt');
Route::post('/admin/logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');

/* ================= Super Admin panel (platform owner) ================= */

Route::prefix('super')->middleware(['auth', 'super.admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Super\SuperAdminController::class, 'overview'])->name('super.overview');

    // landing-design orders (source='landing') from the public showcase cart —
    // store/product orders stay in the client admin panel only
    Route::get('/orders', [\App\Http\Controllers\Super\OrderController::class, 'index'])->name('super.orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Super\OrderController::class, 'show'])->name('super.orders.show');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Super\OrderController::class, 'updateStatus'])->name('super.orders.status');
    Route::post('/orders/{order}/payment', [\App\Http\Controllers\Super\OrderController::class, 'updatePaymentStatus'])->name('super.orders.payment');

    // admin (client) user management — create, permission matrix, activate/deactivate
    Route::get('/admins', [\App\Http\Controllers\Super\SuperAdminController::class, 'index'])->name('super.admins.index');
    Route::post('/admins', [\App\Http\Controllers\Super\SuperAdminController::class, 'store'])->name('super.admins.store');
    Route::get('/admins/{user}/edit', [\App\Http\Controllers\Super\SuperAdminController::class, 'edit'])->name('super.admins.edit');
    Route::put('/admins/{user}', [\App\Http\Controllers\Super\SuperAdminController::class, 'update'])->name('super.admins.update');
    Route::post('/admins/{user}/toggle', [\App\Http\Controllers\Super\SuperAdminController::class, 'toggle'])->name('super.admins.toggle');
    Route::post('/admins/{user}/password', [\App\Http\Controllers\Super\SuperAdminController::class, 'updatePassword'])->name('super.admins.password');
    Route::post('/admins/{user}/industry', [\App\Http\Controllers\Super\SuperAdminController::class, 'applyIndustry'])->name('super.admins.industry');
    Route::delete('/admins/{user}', [\App\Http\Controllers\Super\SuperAdminController::class, 'destroy'])->name('super.admins.destroy');
});

/* ================= Admin panel (permission-scoped) =================
 * Dashboard + the notification bell are always available to every admin.
 * Every other route carries an explicit `perm:<module>.<feature>` guard
 * (config/permissions.php). Tracking saves re-check the per-pixel permission
 * in the controller ({key} can't ride on middleware). Admin-user management
 * stays super-admin only — never grantable.
 */
Route::prefix('admin')->middleware(['auth', 'admin.role'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/orders', [Admin\OrderController::class, 'index'])->middleware('perm:orders.view')->name('admin.orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->middleware('perm:orders.view')->name('admin.orders.show');
    Route::post('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->middleware('perm:orders.status_update')->name('admin.orders.status');
    Route::post('/orders/{order}/payment', [Admin\OrderController::class, 'updatePaymentStatus'])->middleware('perm:orders.payment')->name('admin.orders.payment');
    Route::delete('/orders/{order}', [Admin\OrderController::class, 'destroy'])->middleware('perm:orders.delete')->name('admin.orders.destroy');

    // Pathao courier API — settings live under delivery, sending is an order action
    Route::get('/settings/pathao', [Admin\PathaoController::class, 'page'])->middleware('perm:delivery.courier')->name('admin.settings.pathao');
    Route::post('/settings/pathao', [Admin\PathaoController::class, 'saveSettings'])->middleware('perm:delivery.courier')->name('admin.settings.pathao.save');
    Route::post('/settings/pathao/test', [Admin\PathaoController::class, 'testConnection'])->middleware('perm:delivery.courier')->name('admin.settings.pathao.test');
    Route::post('/orders/{order}/pathao', [Admin\PathaoController::class, 'sendOrder'])->middleware('perm:orders.courier')->name('admin.orders.pathao.send');
    Route::post('/orders/{order}/pathao/status', [Admin\PathaoController::class, 'refreshStatus'])->middleware('perm:orders.courier')->name('admin.orders.pathao.status');

    // Debug panel — super admin only (email guard also lives in the controller)
    Route::get('/debug', [Admin\DebugController::class, 'page'])->name('admin.debug');
    Route::post('/debug/toggle', [Admin\DebugController::class, 'toggle'])->name('admin.debug.toggle');

    Route::get('/complaints', [Admin\ComplaintController::class, 'index'])->middleware('perm:complaints.view')->name('admin.complaints');
    Route::post('/complaints/{complaint}/toggle', [Admin\ComplaintController::class, 'toggle'])->middleware('perm:complaints.resolve')->name('admin.complaints.toggle');
    Route::delete('/complaints/{complaint}', [Admin\ComplaintController::class, 'destroy'])->middleware('perm:complaints.delete')->name('admin.complaints.destroy');

    // customers (derived from orders) — search + rename + delete
    Route::get('/customers', [Admin\CustomerController::class, 'index'])->middleware('perm:customers.view')->name('admin.customers');
    Route::get('/customers/export/{type}', [Admin\CustomerController::class, 'export'])
        ->where('type', 'pdf|csv')->middleware('perm:customers.view')->name('admin.customers.export');
    Route::post('/customers/rename', [Admin\CustomerController::class, 'rename'])->middleware('perm:customers.rename')->name('admin.customers.rename');
    Route::delete('/customers/{phone}', [Admin\CustomerController::class, 'destroy'])
        ->where('phone', '[0-9]+')->middleware('perm:customers.delete')->name('admin.customers.destroy');

    // suppliers + purchase history
    Route::get('/suppliers', [Admin\SupplierController::class, 'index'])->middleware('perm:suppliers.view')->name('admin.suppliers');
    Route::post('/suppliers', [Admin\SupplierController::class, 'store'])->middleware('perm:suppliers.create')->name('admin.suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [Admin\SupplierController::class, 'edit'])->middleware('perm:suppliers.edit')->name('admin.suppliers.edit');
    Route::get('/suppliers/{supplier}', [Admin\SupplierController::class, 'show'])->middleware('perm:suppliers.view')->name('admin.suppliers.show');
    Route::post('/suppliers/{supplier}', [Admin\SupplierController::class, 'update'])->middleware('perm:suppliers.edit')->name('admin.suppliers.update');
    Route::post('/suppliers/{supplier}/toggle', [Admin\SupplierController::class, 'toggle'])->middleware('perm:suppliers.edit')->name('admin.suppliers.toggle');
    Route::delete('/suppliers/{supplier}', [Admin\SupplierController::class, 'destroy'])->middleware('perm:suppliers.delete')->name('admin.suppliers.destroy');
    Route::post('/suppliers/{supplier}/purchases', [Admin\SupplierController::class, 'storePurchase'])->middleware('perm:suppliers.purchases')->name('admin.suppliers.purchases.store');
    Route::delete('/purchases/{purchase}', [Admin\SupplierController::class, 'destroyPurchase'])->middleware('perm:suppliers.purchases')->name('admin.purchases.destroy');

    Route::get('/coupons', [Admin\CouponController::class, 'index'])->middleware('perm:coupons.view')->name('admin.coupons');
    Route::post('/coupons', [Admin\CouponController::class, 'store'])->middleware('perm:coupons.create')->name('admin.coupons.store');
    Route::post('/coupons/{coupon}', [Admin\CouponController::class, 'update'])->middleware('perm:coupons.edit')->name('admin.coupons.update');
    Route::post('/coupons/{coupon}/toggle', [Admin\CouponController::class, 'toggle'])->middleware('perm:coupons.edit')->name('admin.coupons.toggle');
    Route::delete('/coupons/{coupon}', [Admin\CouponController::class, 'destroy'])->middleware('perm:coupons.delete')->name('admin.coupons.destroy');
    Route::get('/reviews', [Admin\ReviewController::class, 'index'])->middleware('perm:reviews.view')->name('admin.reviews');
    Route::post('/reviews', [Admin\ReviewController::class, 'save'])->middleware('perm:reviews.edit')->name('admin.reviews.save');
    Route::get('/products', [Admin\ProductController::class, 'index'])->middleware('perm:products.view')->name('admin.products.index');
    Route::get('/products/create', [Admin\ProductController::class, 'create'])->middleware('perm:products.create')->name('admin.products.create');
    Route::post('/products', [Admin\ProductController::class, 'store'])->middleware('perm:products.create')->name('admin.products.store');
    Route::get('/products/{product}', [Admin\ProductController::class, 'show'])->middleware('perm:products.view')->name('admin.products.show');
    Route::get('/products/{product}/edit', [Admin\ProductController::class, 'edit'])->middleware('perm:products.edit')->name('admin.products.edit');
    Route::put('/products/{product}', [Admin\ProductController::class, 'update'])->middleware('perm:products.edit')->name('admin.products.update');
    Route::post('/products/{product}/toggle', [Admin\ProductController::class, 'toggle'])->middleware('perm:products.edit')->name('admin.products.toggle');
    Route::delete('/products/{product}', [Admin\ProductController::class, 'destroy'])->middleware('perm:products.delete')->name('admin.products.destroy');

    Route::get('/taxonomy', [Admin\TaxonomyController::class, 'index'])->middleware('perm:taxonomy.view')->name('admin.taxonomy');
    Route::get('/modules/{module}', [Admin\ModuleController::class, 'show'])->name('admin.module'); // perm checked in the controller (module → permission mapping)
    Route::post('/taxonomy/category', [Admin\TaxonomyController::class, 'storeCategory'])->middleware('perm:taxonomy.manage_categories')->name('admin.taxonomy.category.store');
    Route::post('/taxonomy/category/{category}/toggle', [Admin\TaxonomyController::class, 'toggleCategory'])->middleware('perm:taxonomy.manage_categories')->name('admin.taxonomy.category.toggle');
    Route::delete('/taxonomy/category/{category}', [Admin\TaxonomyController::class, 'destroyCategory'])->middleware('perm:taxonomy.manage_categories')->name('admin.taxonomy.category.destroy');
    Route::post('/taxonomy/brand', [Admin\TaxonomyController::class, 'storeBrand'])->middleware('perm:taxonomy.manage_brands')->name('admin.taxonomy.brand.store');
    Route::post('/taxonomy/brand/{brand}/toggle', [Admin\TaxonomyController::class, 'toggleBrand'])->middleware('perm:taxonomy.manage_brands')->name('admin.taxonomy.brand.toggle');
    Route::delete('/taxonomy/brand/{brand}', [Admin\TaxonomyController::class, 'destroyBrand'])->middleware('perm:taxonomy.manage_brands')->name('admin.taxonomy.brand.destroy');

    Route::get('/settings/brand', [Admin\SettingController::class, 'brand'])->middleware('perm:brand_settings.view')->name('admin.settings.brand');
    Route::post('/settings/brand', [Admin\SettingController::class, 'saveBrand'])->middleware('perm:brand_settings.edit')->name('admin.settings.brand.save');
    // theme: one perm per feature — each POST protects exactly the card/button
    // that triggers it on the theme page (config/permissions.php)
    Route::get('/settings/theme', [Admin\SettingController::class, 'theme'])->middleware('perm:theme.view')->name('admin.settings.theme');
    Route::post('/settings/theme', [Admin\SettingController::class, 'saveTheme'])->middleware('perm:theme.ready_made')->name('admin.settings.theme.save');
    Route::post('/settings/theme/custom', [Admin\SettingController::class, 'saveCustomTheme'])->middleware('perm:theme.custom_colors')->name('admin.settings.theme.custom');
    Route::post('/settings/theme/reset', [Admin\SettingController::class, 'resetTheme'])->middleware('perm:theme.reset')->name('admin.settings.theme.reset');
    Route::post('/settings/theme/my-theme', [Admin\SettingController::class, 'saveMyTheme'])->middleware('perm:theme.saved_themes')->name('admin.settings.theme.my.save');
    Route::post('/settings/theme/my-theme/delete', [Admin\SettingController::class, 'deleteMyTheme'])->middleware('perm:theme.saved_themes')->name('admin.settings.theme.my.delete');
    Route::post('/settings/theme/history-restore', [Admin\SettingController::class, 'restoreHistory'])->middleware('perm:theme.recent_themes')->name('admin.settings.theme.history.restore');
    Route::post('/settings/theme/fonts', [Admin\SettingController::class, 'saveFonts'])->middleware('perm:theme.fonts')->name('admin.settings.theme.fonts');
    Route::post('/settings/theme/style', [Admin\SettingController::class, 'saveStyle'])->middleware('perm:theme.style_tokens')->name('admin.settings.theme.style');
    Route::post('/settings/theme/festive', [Admin\SettingController::class, 'saveFestive'])->middleware('perm:theme.festive')->name('admin.settings.theme.festive');
    Route::get('/settings/delivery', [Admin\SettingController::class, 'delivery'])->middleware('perm:delivery.view')->name('admin.settings.delivery');
    Route::post('/settings/delivery', [Admin\SettingController::class, 'saveDelivery'])->middleware('perm:delivery.edit')->name('admin.settings.delivery.save');
    // landing content: one perm per tab (each tab form only saves its own keys)
    Route::get('/settings/content', [Admin\SettingController::class, 'content'])->middleware('perm:content.view')->name('admin.settings.content');
    Route::post('/settings/content/hero', [Admin\SettingController::class, 'saveContent'])->middleware('perm:content.hero')->name('admin.settings.content.hero');
    Route::post('/settings/content/sections', [Admin\SettingController::class, 'saveContent'])->middleware('perm:content.sections')->name('admin.settings.content.sections');
    Route::post('/settings/content/order', [Admin\SettingController::class, 'saveContent'])->middleware('perm:content.order_form')->name('admin.settings.content.order');
    Route::post('/settings/content/footer', [Admin\SettingController::class, 'saveContent'])->middleware('perm:content.footer')->name('admin.settings.content.footer');
    Route::get('/settings/sections', [Admin\SettingController::class, 'sections'])->middleware('perm:sections.view')->name('admin.settings.sections');
    // industry re-skin re-skins the whole site for THIS deployment — grantable
    // per-theme feature (with confirm dialog), the /super shortcut stays super-only
    Route::post('/settings/industry', [Admin\SettingController::class, 'applyIndustry'])->middleware('perm:theme.industry_preset')->name('admin.settings.industry.apply');
    Route::post('/settings/industry/clear', [Admin\SettingController::class, 'clearIndustry'])->middleware('perm:theme.industry_preset')->name('admin.settings.industry.clear');
    Route::post('/settings/sections', [Admin\SettingController::class, 'saveSections'])->middleware('perm:sections.edit')->name('admin.settings.sections.save');
    Route::get('/settings/tracking', [Admin\SettingController::class, 'tracking'])->middleware('perm:tracking.view')->name('admin.settings.tracking');
    // per-pixel permission is checked inside the controller ({key} can't be
    // interpolated into middleware params) — only granted pixels may be saved
    Route::post('/settings/tracking/{key}', [Admin\SettingController::class, 'saveTracking'])->name('admin.settings.tracking.save');
    Route::get('/settings/payment', [Admin\SettingController::class, 'payment'])->middleware('perm:payment.view')->name('admin.settings.payment');
    Route::post('/settings/payment/toggle', [Admin\SettingController::class, 'savePaymentToggle'])->middleware('perm:payment.online_toggle')->name('admin.settings.payment.toggle');
    Route::post('/settings/payment/bkash', [Admin\SettingController::class, 'savePaymentBkash'])->middleware('perm:payment.bkash_edit')->name('admin.settings.payment.bkash');
    Route::post('/settings/payment/nagad', [Admin\SettingController::class, 'savePaymentNagad'])->middleware('perm:payment.nagad_edit')->name('admin.settings.payment.nagad');
    Route::get('/seo', [Admin\SeoController::class, 'index'])->middleware('perm:seo.view')->name('admin.seo');
    Route::post('/seo', [Admin\SeoController::class, 'save'])->middleware('perm:seo.edit')->name('admin.seo.save');
    Route::get('/robots', [Admin\SeoController::class, 'robotsPage'])->middleware('perm:robots.view')->name('admin.robots');
    Route::post('/robots', [Admin\SeoController::class, 'saveRobots'])->middleware('perm:robots.edit')->name('admin.robots.save');
    Route::get('/redirects', [Admin\RedirectController::class, 'index'])->middleware('perm:redirects.view')->name('admin.redirects.index');
    Route::post('/redirects', [Admin\RedirectController::class, 'store'])->middleware('perm:redirects.manage')->name('admin.redirects.store');
    Route::post('/redirects/{redirect}/toggle', [Admin\RedirectController::class, 'toggle'])->middleware('perm:redirects.manage')->name('admin.redirects.toggle');
    Route::delete('/redirects/{redirect}', [Admin\RedirectController::class, 'destroy'])->middleware('perm:redirects.manage')->name('admin.redirects.destroy');
    Route::get('/sitemap', [Admin\SitemapController::class, 'page'])->middleware('perm:sitemap.view')->name('admin.sitemap');
    Route::post('/sitemap/urls', [Admin\SitemapController::class, 'store'])->middleware('perm:sitemap.manage')->name('admin.sitemap.store');
    Route::post('/sitemap/urls/{url}/toggle', [Admin\SitemapController::class, 'toggle'])->middleware('perm:sitemap.manage')->name('admin.sitemap.toggle');
    Route::delete('/sitemap/urls/{url}', [Admin\SitemapController::class, 'destroy'])->middleware('perm:sitemap.manage')->name('admin.sitemap.destroy');

    // admin user management moved to /super/admins — legacy URIs stay alive,
    // but only for the super admin (GET simply forwards to the new panel)
    Route::get('/admin-management', [Admin\AdminManagerController::class, 'index'])->middleware('super.admin')->name('admin.admins.index');
    Route::post('/admin-management', [Admin\AdminManagerController::class, 'store'])->middleware('super.admin')->name('admin.admins.store');
    Route::delete('/admin-management/{user}', [Admin\AdminManagerController::class, 'destroy'])
        ->middleware('super.admin')->name('admin.admins.destroy');
    Route::put('/admin-management/{user}', [Admin\AdminManagerController::class, 'update'])->middleware('super.admin')->name('admin.admins.update');

    // আমার অ্যাকাউন্ট — self service (nijer password change), sob admin er jonno
    Route::get('/account', [Admin\AccountController::class, 'index'])->name('admin.account');
    Route::post('/account/password', [Admin\AccountController::class, 'changePassword'])->name('admin.account.password');

    // notification bell: mark everything as read (always available to admins)
    Route::post('/notifications/read-all', function () {
        \App\Models\OrderNotification::where('is_read', false)->update(['is_read' => true]);
        return back();
    })->name('admin.notifications.readAll');
});
