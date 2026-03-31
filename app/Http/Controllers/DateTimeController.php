<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DateTimeController extends Controller
{
    public const TIMEZONE_KEY = 'timezone';
    public const DATE_FORMAT_KEY = 'date_format';
    public const TIME_FORMAT_KEY = 'time_format'; // 12 or 24
    public const BUSINESS_HOURS_KEY = 'business_hours';

    public const DEFAULT_TIMEZONE = 'Europe/Amsterdam';
    public const DEFAULT_DATE_FORMAT = 'd/m/Y';
    public const DEFAULT_TIME_FORMAT = '24';

    /**
     * Show Date & Time management page
     */
    public function index()
    {
        $timezones = $this->getTimezonesList();
        return view('dashboard.datetime', compact('timezones'));
    }

    /**
     * API: Get current date/time settings
     */
    public function getSettings()
    {
        $timezone = Setting::get(self::TIMEZONE_KEY, self::DEFAULT_TIMEZONE);
        $dateFormat = Setting::get(self::DATE_FORMAT_KEY, self::DEFAULT_DATE_FORMAT);
        $timeFormat = Setting::get(self::TIME_FORMAT_KEY, self::DEFAULT_TIME_FORMAT);
        $businessHours = Setting::get(self::BUSINESS_HOURS_KEY, $this->defaultBusinessHours());

        $dt = now($timezone);
        $datePart = $dt->format($dateFormat);
        $timePart = $timeFormat === '12' ? $dt->format('g:i A') : $dt->format('H:i');
        $currentFormatted = $datePart . ' ' . $timePart;

        return response()->json([
            'success' => true,
            'timezone' => $timezone,
            'date_format' => $dateFormat,
            'time_format' => $timeFormat,
            'business_hours' => $businessHours,
            'server_timezone' => config('app.timezone'),
            'current_datetime' => $dt->toIso8601String(),
            'current_datetime_formatted' => $currentFormatted,
        ]);
    }

    /**
     * API: Update date/time settings
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'timezone' => 'required|string|timezone',
            'date_format' => 'required|string|in:d/m/Y,m/d/Y,Y-m-d,d-m-Y,j F Y',
            'time_format' => 'required|string|in:12,24',
            'business_hours' => 'nullable|array',
            'business_hours.*.open' => 'nullable|string|regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
            'business_hours.*.close' => 'nullable|string|regex:/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
            'business_hours.*.closed' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        Setting::set(self::TIMEZONE_KEY, $request->timezone, 'string', 'Application timezone');
        Setting::set(self::DATE_FORMAT_KEY, $request->date_format, 'string', 'Date display format');
        Setting::set(self::TIME_FORMAT_KEY, $request->time_format, 'string', 'Time display format (12 or 24 hour)');
        Setting::set(self::BUSINESS_HOURS_KEY, $request->business_hours ?? $this->defaultBusinessHours(), 'json', 'Business hours per day');

        $dt = now($request->timezone);
        $datePart = $dt->format($request->date_format);
        $timePart = $request->time_format === '12' ? $dt->format('g:i A') : $dt->format('H:i');

        return response()->json([
            'success' => true,
            'message' => 'Date & time settings saved.',
            'current_datetime' => $dt->toIso8601String(),
            'current_datetime_formatted' => $datePart . ' ' . $timePart,
        ]);
    }

    /**
     * API: Get list of timezones (grouped by region)
     */
    public function timezones()
    {
        return response()->json([
            'success' => true,
            'timezones' => $this->getTimezonesList(),
        ]);
    }

    private function getTimezonesList(): array
    {
        $identifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $grouped = [];
        foreach ($identifiers as $tz) {
            $parts = explode('/', $tz, 2);
            $region = $parts[0] ?? 'Other';
            $city = $parts[1] ?? $tz;
            if (!isset($grouped[$region])) {
                $grouped[$region] = [];
            }
            $grouped[$region][$tz] = str_replace('_', ' ', $city);
        }
        ksort($grouped);
        foreach ($grouped as $region => $cities) {
            asort($grouped[$region]);
        }
        return $grouped;
    }

    private function defaultBusinessHours(): array
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $default = [];
        foreach ($days as $day) {
            $default[$day] = $day === 'sunday'
                ? ['closed' => true]
                : ['open' => '09:00', 'close' => '17:00', 'closed' => false];
        }
        return $default;
    }
}
