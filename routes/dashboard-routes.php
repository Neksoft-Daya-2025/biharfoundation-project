<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes (Public)
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Dashboard Routes (Protected)
Route::group(['prefix' => 'dashboard', 'middleware' => ['web', 'admin.auth']], function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Analytics Dashboard
    Route::get('/analytics', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('dashboard.analytics');
    
    // Settings Dashboard
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('dashboard.settings');
    
    // Customers Dashboard
    Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('dashboard.customers');
    
    // Orders Dashboard
    Route::get('/orders', [App\Http\Controllers\Dashboard\OrderController::class, 'index'])->name('dashboard.orders');
    Route::get('/orders/{order}', [App\Http\Controllers\Dashboard\OrderController::class, 'show'])->name('dashboard.orders.show');
    Route::post('/orders/{order}/status', [App\Http\Controllers\Dashboard\OrderController::class, 'updateStatus'])->name('dashboard.orders.status');
    
    // Products Dashboard
    Route::get('/products', [App\Http\Controllers\Dashboard\ProductController::class, 'index'])->name('dashboard.products');
    Route::get('/products/create', [App\Http\Controllers\Dashboard\ProductController::class, 'create'])->name('dashboard.products.create');
    Route::post('/products', [App\Http\Controllers\Dashboard\ProductController::class, 'store'])->name('dashboard.products.store');
    Route::get('/products/{product}', [App\Http\Controllers\Dashboard\ProductController::class, 'show'])->name('dashboard.products.show');
    Route::get('/products/{product}/edit', [App\Http\Controllers\Dashboard\ProductController::class, 'edit'])->name('dashboard.products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Dashboard\ProductController::class, 'update'])->name('dashboard.products.update');
    Route::delete('/products/{product}', [App\Http\Controllers\Dashboard\ProductController::class, 'destroy'])->name('dashboard.products.destroy');
    Route::post('/products/bulk-delete', [App\Http\Controllers\Dashboard\ProductController::class, 'destroyBulk'])->name('dashboard.products.bulk-destroy');

    // Product Categories
    Route::get('/categories', [App\Http\Controllers\Dashboard\ProductCategoryController::class, 'index'])->name('dashboard.categories');
    Route::get('/categories/create', [App\Http\Controllers\Dashboard\ProductCategoryController::class, 'create'])->name('dashboard.categories.create');
    Route::post('/categories', [App\Http\Controllers\Dashboard\ProductCategoryController::class, 'store'])->name('dashboard.categories.store');
    Route::get('/categories/{category}/edit', [App\Http\Controllers\Dashboard\ProductCategoryController::class, 'edit'])->name('dashboard.categories.edit');
    Route::put('/categories/{category}', [App\Http\Controllers\Dashboard\ProductCategoryController::class, 'update'])->name('dashboard.categories.update');
    Route::delete('/categories/{category}', [App\Http\Controllers\Dashboard\ProductCategoryController::class, 'destroy'])->name('dashboard.categories.destroy');
    
    // Notifications Dashboard
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('dashboard.notifications');
    Route::get('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'show'])->name('dashboard.notifications.show');

    // Events Dashboard
    Route::get('/events', [App\Http\Controllers\Dashboard\EventController::class, 'index'])->name('dashboard.events');
    Route::get('/events/create', [App\Http\Controllers\Dashboard\EventController::class, 'create'])->name('dashboard.events.create');
    Route::post('/events', [App\Http\Controllers\Dashboard\EventController::class, 'store'])->name('dashboard.events.store');
    Route::get('/events/attendees', [App\Http\Controllers\Dashboard\EventController::class, 'attendees'])->name('dashboard.events.attendees');
    Route::get('/events/{event}', [App\Http\Controllers\Dashboard\EventController::class, 'show'])->name('dashboard.events.show');
    Route::get('/events/{event}/edit', [App\Http\Controllers\Dashboard\EventController::class, 'edit'])->name('dashboard.events.edit');
    Route::put('/events/{event}', [App\Http\Controllers\Dashboard\EventController::class, 'update'])->name('dashboard.events.update');
    Route::delete('/events/{event}', [App\Http\Controllers\Dashboard\EventController::class, 'destroy'])->name('dashboard.events.destroy');
    Route::get('/events/{event}/ticket-types/create', [App\Http\Controllers\Dashboard\EventController::class, 'ticketTypeCreate'])->name('dashboard.events.ticket-types.create');
    Route::post('/events/{event}/ticket-types', [App\Http\Controllers\Dashboard\EventController::class, 'ticketTypeStore'])->name('dashboard.events.ticket-types.store');
    Route::get('/events/{event}/ticket-types/{ticketType}/edit', [App\Http\Controllers\Dashboard\EventController::class, 'ticketTypeEdit'])->name('dashboard.events.ticket-types.edit');
    Route::put('/events/{event}/ticket-types/{ticketType}', [App\Http\Controllers\Dashboard\EventController::class, 'ticketTypeUpdate'])->name('dashboard.events.ticket-types.update');
    Route::delete('/events/{event}/ticket-types/{ticketType}', [App\Http\Controllers\Dashboard\EventController::class, 'ticketTypeDestroy'])->name('dashboard.events.ticket-types.destroy');
    Route::post('/events/bookings/{booking}/status', [App\Http\Controllers\Dashboard\EventController::class, 'updateBookingStatus'])->name('dashboard.events.bookings.update-status');

    // Blog Dashboard
    Route::get('/blog', [App\Http\Controllers\Dashboard\BlogController::class, 'index'])->name('dashboard.blog');
    Route::get('/blog/create', [App\Http\Controllers\Dashboard\BlogController::class, 'create'])->name('dashboard.blog.create');
    Route::post('/blog', [App\Http\Controllers\Dashboard\BlogController::class, 'store'])->name('dashboard.blog.store');
    Route::get('/blog/{post}/edit', [App\Http\Controllers\Dashboard\BlogController::class, 'edit'])->name('dashboard.blog.edit');
    Route::put('/blog/{post}', [App\Http\Controllers\Dashboard\BlogController::class, 'update'])->name('dashboard.blog.update');
    Route::delete('/blog/{post}', [App\Http\Controllers\Dashboard\BlogController::class, 'destroy'])->name('dashboard.blog.destroy');
});

// API Routes (Protected)
Route::group(['prefix' => 'api', 'middleware' => ['web', 'admin.auth']], function () {
    // Settings API
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'getAll'])->name('api.settings.index');
    Route::post('/settings', [App\Http\Controllers\SettingsController::class, 'updateSetting'])->name('api.settings.update');
    Route::post('/clear-cache', [App\Http\Controllers\SettingsController::class, 'clearCache'])->name('api.clear-cache');
    
    // SMTP Configuration API
    Route::get('/smtp-config', [App\Http\Controllers\SettingsController::class, 'getSMTPConfig'])->name('api.smtp-config.get');
    Route::post('/smtp-config', [App\Http\Controllers\SettingsController::class, 'saveSMTPConfig'])->name('api.smtp-config.save');
    Route::post('/smtp-config/test', [App\Http\Controllers\SettingsController::class, 'testSMTPConnection'])->name('api.smtp-config.test');
    
    // Analytics API
    Route::get('/analytics', [App\Http\Controllers\AnalyticsController::class, 'api'])->name('api.analytics');
    
    // Customers API
    Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'getAll'])->name('api.customers.index');
    Route::get('/customers/export', [App\Http\Controllers\CustomerController::class, 'exportCSV'])->name('api.customers.export');
    
    // Orders API
    Route::get('/orders', [App\Http\Controllers\Dashboard\OrderController::class, 'api'])->name('api.orders.index');
    Route::post('/orders/{order}/status', [App\Http\Controllers\Dashboard\OrderController::class, 'updateStatus'])->name('api.orders.status');

    // Notifications API
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'api'])->name('api.notifications.index');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('api.notifications.unread-count');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markRead'])->name('api.notifications.mark-read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('api.notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('api.notifications.destroy');
    Route::delete('/notifications/clear/read', [App\Http\Controllers\NotificationController::class, 'clearRead'])->name('api.notifications.clear-read');
    Route::delete('/notifications/clear/all', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('api.notifications.clear-all');

    // Date & Time API
    Route::get('/datetime', [App\Http\Controllers\DateTimeController::class, 'getSettings'])->name('api.datetime.get');
    Route::post('/datetime', [App\Http\Controllers\DateTimeController::class, 'updateSettings'])->name('api.datetime.update');
    Route::get('/datetime/timezones', [App\Http\Controllers\DateTimeController::class, 'timezones'])->name('api.datetime.timezones');
});
