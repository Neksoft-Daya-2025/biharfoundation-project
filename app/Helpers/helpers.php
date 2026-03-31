<?php

if (!function_exists('currency_code')) {
    function currency_code(): string
    {
        if (!class_exists(\App\Models\Setting::class)) {
            return 'EUR';
        }
        return (string) (\App\Models\Setting::get('currency', 'EUR') ?: 'EUR');
    }
}

if (!function_exists('currency_symbol')) {
    function currency_symbol(): string
    {
        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'CHF' => 'Fr',
            'JPY' => '¥',
            'INR' => '₹',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'CNY' => '¥',
            'BRL' => 'R$',
            'MXN' => '$',
            'ZAR' => 'R',
        ];
        $code = currency_code();
        return $symbols[$code] ?? $code;
    }
}

if (!function_exists('format_money')) {
    function format_money($amount, ?int $decimals = 2): string
    {
        return currency_symbol() . number_format((float) $amount, $decimals);
    }
}

if (!function_exists('current_theme')) {
    function current_theme(): string
    {
        $id = 'default';
        if (class_exists(\App\Models\Setting::class)) {
            $id = (string) (\App\Models\Setting::get('active_theme', 'default') ?: 'default');
        }
        $themes = config('themes', []);
        return isset($themes[$id]) ? $id : 'default';
    }
}

if (!function_exists('theme_view')) {
    function theme_view(string $name): string
    {
        $theme = current_theme();
        $views = config("themes.{$theme}.views", 'themes.default');
        return $views . '.' . $name;
    }
}

if (!function_exists('theme_asset')) {
    function theme_asset(string $path): string
    {
        $theme = current_theme();
        $assets = config("themes.{$theme}.assets", 'themes/default');
        $base = rtrim($assets, '/');
        $path = ltrim($path, '/');
        return asset($base . '/' . $path);
    }
}

/*
 * Date / Time / Timezone helpers (use settings: timezone, date_format, time_format)
 */
if (!function_exists('app_timezone')) {
    function app_timezone(): string
    {
        if (!class_exists(\App\Models\Setting::class)) {
            return config('app.timezone', 'UTC');
        }
        return (string) (\App\Models\Setting::get('timezone', config('app.timezone', 'UTC')) ?: config('app.timezone', 'UTC'));
    }
}

if (!function_exists('app_date_format')) {
    function app_date_format(): string
    {
        if (!class_exists(\App\Models\Setting::class)) {
            return 'd/m/Y';
        }
        return (string) (\App\Models\Setting::get('date_format', 'd/m/Y') ?: 'd/m/Y');
    }
}

if (!function_exists('app_time_format')) {
    /** Returns '12' or '24' */
    function app_time_format(): string
    {
        if (!class_exists(\App\Models\Setting::class)) {
            return '24';
        }
        return (string) (\App\Models\Setting::get('time_format', '24') ?: '24');
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date/datetime in app timezone and date format.
     * @param \DateTimeInterface|string|null $date
     * @param string|null $format Override format (optional)
     */
    function format_date($date, ?string $format = null): string
    {
        if ($date === null || $date === '') {
            return '';
        }
        $dt = $date instanceof \DateTimeInterface
            ? \Carbon\Carbon::parse($date)->timezone(app_timezone())
            : \Carbon\Carbon::parse($date, app_timezone());
        return $dt->format($format ?? app_date_format());
    }
}

if (!function_exists('format_time')) {
    /**
     * Format a date/datetime as time only (12h or 24h from settings).
     * @param \DateTimeInterface|string|null $date
     */
    function format_time($date): string
    {
        if ($date === null || $date === '') {
            return '';
        }
        $dt = $date instanceof \DateTimeInterface
            ? \Carbon\Carbon::parse($date)->timezone(app_timezone())
            : \Carbon\Carbon::parse($date, app_timezone());
        return app_time_format() === '12'
            ? $dt->format('g:i A')
            : $dt->format('H:i');
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format a date/datetime as date + time in app timezone and formats.
     * @param \DateTimeInterface|string|null $date
     */
    function format_datetime($date): string
    {
        if ($date === null || $date === '') {
            return '';
        }
        $dt = $date instanceof \DateTimeInterface
            ? \Carbon\Carbon::parse($date)->timezone(app_timezone())
            : \Carbon\Carbon::parse($date, app_timezone());
        $datePart = $dt->format(app_date_format());
        $timePart = app_time_format() === '12'
            ? $dt->format('g:i A')
            : $dt->format('H:i');
        return $datePart . ' ' . $timePart;
    }
}

if (!function_exists('business_hours')) {
    /**
     * Get business hours from settings (JSON: day => { open, close, closed }).
     */
    function business_hours(): array
    {
        if (!class_exists(\App\Models\Setting::class)) {
            return [];
        }
        $hours = \App\Models\Setting::get('business_hours', []);
        return is_array($hours) ? $hours : [];
    }
}
