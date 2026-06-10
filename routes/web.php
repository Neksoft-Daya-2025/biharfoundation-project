<?php

use Illuminate\Support\Facades\Route;

// Root: Malbi's Kitchen home (logged-in admins go to dashboard)
Route::get('/', function () {
    if (session()->has('admin_logged_in') && session()->get('admin_logged_in') === true) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('home');

// Malbi's Kitchen storefront (Blade) — routes referenced by header, footer, etc.
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/blog', [App\Http\Controllers\PublicBlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [App\Http\Controllers\PublicBlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
Route::get('/privacy', fn () => view('privacy'))->name('privacy');
Route::get('/terms', fn () => view('terms'))->name('terms');
Route::get('/services', fn () => view('services'))->name('services');

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

// Legacy Malbi Blade storefront (SPA at /home/* uses NestJS /api/v1 for events/contact/booking).
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
