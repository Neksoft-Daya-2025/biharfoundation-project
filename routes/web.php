<?php

use Illuminate\Support\Facades\Route;

// Root: redirect to dashboard (if logged in) or login
Route::get('/', function () {
    if (session()->has('admin_logged_in') && session()->get('admin_logged_in') === true) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Lovable SPA (React): always this Blade view; assets live in public/themes/lovable/
Route::get('/theme-preview/{path?}', function () {
    return view('themes.lovable.home');
})->where('path', '.*')->name('theme.preview');

Route::get('/home/{path?}', function () {
    return view('themes.lovable.home');
})->where('path', '.*')->name('public.home');

// Visitor tracking (public) – used by theme layouts to record page views
Route::get('/api/track', [App\Http\Controllers\AnalyticsController::class, 'track'])->name('api.track');
Route::post('/api/analytics/update-location', [App\Http\Controllers\AnalyticsController::class, 'updateVisitorLocation'])->name('api.analytics.update-location');

// Public JSON API for Lovable SPA (session + CSRF via web middleware)
Route::prefix('api/v1')->group(function () {
    Route::get('/site', [App\Http\Controllers\Api\V1\SiteController::class, 'show'])->middleware('throttle:120,1')->name('api.v1.site');
    Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->middleware('throttle:10,1')->name('api.v1.contact');
    Route::get('/events', [App\Http\Controllers\EventController::class, 'apiIndex'])->middleware('throttle:120,1')->name('api.v1.events.index');
    Route::get('/events/{slug}', [App\Http\Controllers\EventController::class, 'apiShow'])->middleware('throttle:120,1')->name('api.v1.events.show');
    Route::post('/events/{event}/book', [App\Http\Controllers\EventController::class, 'apiBook'])->middleware('throttle:30,1')->name('api.v1.events.book');
});

// Storefront Blade routes (not yet wired: CartController, PublicBlogController, OrderController, PaymentController — see app/Http/Controllers).
// Public event listing, detail, booking and confirmation (must define booking-confirmation before {slug})
Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])->name('events.index');
Route::get('/events/booking-confirmation/{reference}', [App\Http\Controllers\EventController::class, 'bookingConfirmation'])->name('events.booking-confirmation');
Route::post('/events/{event}/book', [App\Http\Controllers\EventController::class, 'book'])->name('events.book');
Route::get('/events/{slug}', [App\Http\Controllers\EventController::class, 'show'])->name('events.show');

// Dashboard routes (auth + admin panel)
if (file_exists(__DIR__.'/dashboard-routes.php')) {
    require __DIR__.'/dashboard-routes.php';
}
