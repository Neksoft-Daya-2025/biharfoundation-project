<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'country',
        'country_code',
        'city',
        'latitude',
        'longitude',
        'device_type',
        'browser',
        'os',
        'url',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get statistics for the given number of days
     */
    public static function getStatistics($days = 30)
    {
        $startDate = now()->subDays($days);
        
        // Total visits
        $totalVisits = self::where('visited_at', '>=', $startDate)->count();
        
        // Unique IPs
        $uniqueIps = self::where('visited_at', '>=', $startDate)
            ->distinct('ip_address')
            ->count('ip_address');
        
        // Daily visits
        $dailyVisits = self::where('visited_at', '>=', $startDate)
            ->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Visits by page
        $byPage = self::where('visited_at', '>=', $startDate)
            ->whereNotNull('url')
            ->select('url', DB::raw('COUNT(*) as count'))
            ->groupBy('url')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        
        return [
            'total_visits' => $totalVisits,
            'unique_ips' => $uniqueIps,
            'daily_visits' => $dailyVisits,
            'by_page' => $byPage,
        ];
    }
}
