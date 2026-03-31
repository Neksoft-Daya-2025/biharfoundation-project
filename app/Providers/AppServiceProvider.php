<?php

namespace App\Providers;

use App\Models\Notification as AppNotification;
use App\Models\ProductCategory;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::bind('notification', fn ($value) => AppNotification::findOrFail($value));
        Route::bind('category', fn ($value) => ProductCategory::findOrFail($value));

        // Apply timezone from settings (dashboard Date & Time management)
        try {
            if (class_exists(Setting::class)) {
                $tz = Setting::get('timezone', config('app.timezone'));
                if ($tz && is_string($tz)) {
                    Config::set('app.timezone', $tz);
                    date_default_timezone_set($tz);
                }
            }
        } catch (\Throwable $e) {
            // DB may not be ready during install; keep config default
        }
    }
}
