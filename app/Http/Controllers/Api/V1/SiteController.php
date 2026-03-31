<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SiteController extends Controller
{
    /**
     * Public site metadata (whitelisted keys only).
     */
    public function show(): JsonResponse
    {
        $keys = [
            'site_title',
            'business_name',
            'contact_email',
            'phone',
            'address',
            'timezone',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $value = Setting::get($key);
            if ($value !== null && $value !== '') {
                $settings[$key] = $value;
            }
        }

        return response()->json([
            'data' => [
                'name' => config('app.name'),
                'url' => config('app.url'),
                'settings' => $settings,
            ],
        ]);
    }
}
