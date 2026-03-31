<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->get('days', 30);
        
        $statistics = Visitor::getStatistics($days);
        
        return view('dashboard.analytics', [
            'statistics' => $statistics,
            'days' => $days,
        ]);
    }

    public function api(Request $request)
    {
        try {
            $days = $request->get('days', 30);
            
            // Auto-cleanup: Delete records older than 30 days to maintain space
            // Only run cleanup once per hour to avoid performance issues
            $lastCleanup = cache()->get('visitors_last_cleanup');
            if (!$lastCleanup || now()->diffInHours($lastCleanup) >= 1) {
                $this->cleanupOldVisitors();
                cache()->put('visitors_last_cleanup', now(), now()->addHour());
            }
            
            $statistics = Visitor::getStatistics($days);
            
            // Pagination for recent visitors
            $page = max(1, (int)$request->get('page', 1));
            $perPage = max(1, min(100, (int)$request->get('per_page', 20)));
            
            // Filter by today by default (unless a date filter is specified)
            $filterDate = $request->get('filter_date');
            $recentVisitorsQuery = Visitor::orderBy('visited_at', 'desc');
            
            if ($filterDate === 'today' || !$filterDate) {
                // Default: show only today's visitors
                $recentVisitorsQuery->whereDate('visited_at', today());
            } elseif ($filterDate === 'yesterday') {
                $recentVisitorsQuery->whereDate('visited_at', today()->subDay());
            } elseif ($filterDate === 'week') {
                $recentVisitorsQuery->where('visited_at', '>=', now()->subWeek());
            } elseif ($filterDate === 'month') {
                $recentVisitorsQuery->where('visited_at', '>=', now()->subMonth());
            } elseif ($filterDate === 'all') {
                // Show all visitors
            }
            
            $totalRecent = $recentVisitorsQuery->count();
            $recentVisitors = $recentVisitorsQuery
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get()
                ->map(function ($visitor) {
                    return [
                        'id' => $visitor->id,
                        'ip_address' => $visitor->ip_address,
                        'country' => $visitor->country ?? 'Unknown',
                        'country_code' => $visitor->country_code ?? '',
                        'city' => $visitor->city ?? 'Unknown',
                        'latitude' => $visitor->latitude ? (float) $visitor->latitude : null,
                        'longitude' => $visitor->longitude ? (float) $visitor->longitude : null,
                        'device_type' => $visitor->device_type ?? 'Unknown',
                        'browser' => $visitor->browser ?? 'Unknown',
                        'os' => $visitor->os ?? 'Unknown',
                        'url' => $visitor->url ?? '',
                        'visited_at' => $visitor->visited_at->format('Y-m-d H:i:s'),
                        'visited_at_date' => $visitor->visited_at->format('Y-m-d'),
                        'visited_at_time' => $visitor->visited_at->format('H:i:s'),
                        'visited_at_formatted' => $visitor->visited_at->format('M d, Y'),
                        'visited_at_human' => $visitor->visited_at->diffForHumans(),
                    ];
                });
            
            // Get real-time visitors (last 5 minutes) - no pagination needed
            $realtimeVisitors = Visitor::where('visited_at', '>=', now()->subMinutes(5))
                ->orderBy('visited_at', 'desc')
                ->get()
                ->map(function ($visitor) {
                    // Get coordinates, geocode if missing
                    $latitude = $visitor->latitude;
                    $longitude = $visitor->longitude;
                    
                    if (!$latitude || !$longitude) {
                        $coords = $this->geocodeLocation($visitor->country, $visitor->city, $visitor->country_code);
                        if ($coords) {
                            $latitude = $coords['lat'];
                            $longitude = $coords['lon'];
                            // Update visitor record with coordinates for future use
                            $visitor->update([
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                            ]);
                        }
                    }
                    
                    return [
                        'id' => $visitor->id,
                        'ip_address' => $visitor->ip_address,
                        'country' => $visitor->country ?? 'Unknown',
                        'country_code' => $visitor->country_code ?? '',
                        'city' => $visitor->city ?? 'Unknown',
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'device_type' => $visitor->device_type ?? 'Unknown',
                        'browser' => $visitor->browser ?? 'Unknown',
                        'os' => $visitor->os ?? 'Unknown',
                        'url' => $visitor->url ?? '',
                        'visited_at' => $visitor->visited_at->format('Y-m-d H:i:s'),
                        'visited_at_human' => $visitor->visited_at->diffForHumans(),
                    ];
                });
            
            // Format statistics for charts
            $visitsByDay = [];
            $topPages = [];
            
            if (isset($statistics['daily_visits']) && is_iterable($statistics['daily_visits'])) {
                foreach ($statistics['daily_visits'] as $day) {
                    $visitsByDay[] = [
                        'date' => is_object($day) ? $day->date : ($day['date'] ?? ''),
                        'visits' => is_object($day) ? $day->count : ($day['count'] ?? 0)
                    ];
                }
            }
            
            if (isset($statistics['by_page']) && is_iterable($statistics['by_page'])) {
                foreach ($statistics['by_page'] as $pageItem) {
                    $url = is_object($pageItem) ? $pageItem->url : ($pageItem['url'] ?? '');
                    $count = is_object($pageItem) ? $pageItem->count : ($pageItem['count'] ?? 0);
                    $topPages[] = [
                        'page' => $url ? parse_url($url, PHP_URL_PATH) : 'Unknown',
                        'visits' => (int)$count
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'statistics' => [
                    'total_visits' => (int)($statistics['total_visits'] ?? 0),
                    'unique_visitors' => (int)($statistics['unique_ips'] ?? 0),
                    'visits_by_day' => $visitsByDay,
                    'top_pages' => $topPages,
                ],
                'recent_visitors' => $recentVisitors,
                'realtime_visitors' => $realtimeVisitors,
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => $totalRecent,
                    'last_page' => $totalRecent > 0 ? (int)ceil($totalRecent / $perPage) : 1,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Analytics API Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to load analytics data',
                'message' => config('app.debug') ? $e->getMessage() : 'An error occurred'
            ], 500);
        }
    }
    
    /**
     * Record a visit (public, no auth). Call from theme/front end to log page views.
     * GET /api/track?url=... optional url (defaults to referer or request path).
     */
    public function track(Request $request)
    {
        try {
            $ip = $request->ip();
            if (!$ip || $ip === '127.0.0.1') {
                $ip = $request->header('X-Forwarded-For') ? explode(',', $request->header('X-Forwarded-For'))[0] : $ip;
            }
            if (!$ip) {
                return response()->json(['success' => false], 400);
            }
            $url = $request->get('url') ?: $request->header('Referer') ?: $request->fullUrl();
            $ua = $request->userAgent() ?? '';
            $deviceType = $this->parseDeviceType($ua);
            $browser = $this->parseBrowser($ua);
            $os = $this->parseOs($ua);

            Visitor::create([
                'ip_address' => $ip,
                'url' => strlen($url) > 500 ? substr($url, 0, 500) : $url,
                'device_type' => $deviceType,
                'browser' => $browser,
                'os' => $os,
                'visited_at' => now(),
            ]);
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            \Log::warning('Visitor track failed: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    private function parseDeviceType($ua)
    {
        $ua = strtolower($ua);
        if (str_contains($ua, 'mobile') && !str_contains($ua, 'ipad')) return 'mobile';
        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) return 'tablet';
        return 'desktop';
    }

    private function parseBrowser($ua)
    {
        $ua = strtolower($ua);
        if (str_contains($ua, 'edg/')) return 'Edge';
        if (str_contains($ua, 'chrome')) return 'Chrome';
        if (str_contains($ua, 'firefox')) return 'Firefox';
        if (str_contains($ua, 'safari') && !str_contains($ua, 'chrome')) return 'Safari';
        if (str_contains($ua, 'opera') || str_contains($ua, 'opr/')) return 'Opera';
        return null;
    }

    private function parseOs($ua)
    {
        $ua = strtolower($ua);
        if (str_contains($ua, 'windows')) return 'Windows';
        if (str_contains($ua, 'mac os') || str_contains($ua, 'macintosh')) return 'macOS';
        if (str_contains($ua, 'linux')) return 'Linux';
        if (str_contains($ua, 'android')) return 'Android';
        if (str_contains($ua, 'iphone') || str_contains($ua, 'ipad')) return 'iOS';
        return null;
    }

    /**
     * Update visitor location from browser geolocation API
     */
    public function updateVisitorLocation(Request $request)
    {
        try {
            $ipAddress = $request->ip();
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $country = $request->input('country');
            $countryCode = $request->input('country_code');
            $city = $request->input('city');
            
            if (!$ipAddress) {
                return response()->json(['success' => false, 'message' => 'IP address required'], 400);
            }
            
            // Find the most recent visitor record for this IP (within last 5 minutes)
            $visitor = Visitor::where('ip_address', $ipAddress)
                ->where('visited_at', '>=', now()->subMinutes(5))
                ->orderBy('visited_at', 'desc')
                ->first();
            
            if ($visitor) {
                // Update with browser geolocation data (more accurate than IP)
                $visitor->update([
                    'country' => $country ?? $visitor->country,
                    'country_code' => $countryCode ?? $visitor->country_code,
                    'city' => $city ?? $visitor->city,
                    'latitude' => $latitude ?? $visitor->latitude,
                    'longitude' => $longitude ?? $visitor->longitude,
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Location updated successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Visitor record not found'
            ], 404);
            
        } catch (\Exception $e) {
            \Log::warning('Failed to update visitor location: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location'
            ], 500);
        }
    }
    
    /**
     * Debug endpoint to verify visitor tracking (admin only)
     */
    public function debug(Request $request)
    {
        $totalVisitors = Visitor::count();
        $recentVisitors = Visitor::where('visited_at', '>=', now()->subHour())->count();
        $todayVisitors = Visitor::whereDate('visited_at', today())->count();
        
        $sampleVisitors = Visitor::orderBy('visited_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($visitor) {
                return [
                    'id' => $visitor->id,
                    'ip_address' => $visitor->ip_address,
                    'country' => $visitor->country ?? 'NULL',
                    'country_code' => $visitor->country_code ?? 'NULL',
                    'city' => $visitor->city ?? 'NULL',
                    'device_type' => $visitor->device_type ?? 'NULL',
                    'browser' => $visitor->browser ?? 'NULL',
                    'url' => $visitor->url ?? 'NULL',
                    'visited_at' => $visitor->visited_at->format('Y-m-d H:i:s'),
                ];
            });
        
        return response()->json([
            'success' => true,
            'stats' => [
                'total_visitors' => $totalVisitors,
                'recent_visitors_last_hour' => $recentVisitors,
                'today_visitors' => $todayVisitors,
            ],
            'sample_visitors' => $sampleVisitors,
            'tracking_enabled' => true,
            'middleware_active' => true,
        ]);
    }
    
    /**
     * Geocode location (country/city) to coordinates
     */
    private function geocodeLocation($country, $city, $countryCode)
    {
        if (!$country && !$city && !$countryCode) {
            return null;
        }
        
        // Try geocoding with Nominatim (OpenStreetMap) - free and no API key needed
        $query = '';
        if ($city && $country) {
            $query = urlencode("{$city}, {$country}");
        } elseif ($country) {
            $query = urlencode($country);
        } elseif ($countryCode) {
            $query = urlencode($countryCode);
        } else {
            return null;
        }
        
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 2,
                    'method' => 'GET',
                    'header' => 'User-Agent: Malbis Kitchen Laravel App'
                ]
            ]);
            
            $url = "https://nominatim.openstreetmap.org/search?q={$query}&format=json&limit=1";
            $response = @file_get_contents($url, false, $context);
            
            if ($response) {
                $data = json_decode($response, true);
                if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                    return [
                        'lat' => (float)$data[0]['lat'],
                        'lon' => (float)$data[0]['lon'],
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::debug('Geocoding failed: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Auto-cleanup old visitor records (older than 30 days)
     * This is called automatically to maintain space
     */
    private function cleanupOldVisitors()
    {
        try {
            $cutoffDate = now()->subDays(30);
            $deleted = Visitor::where('visited_at', '<', $cutoffDate)->delete();
            if ($deleted > 0) {
                \Log::info("Cleaned up {$deleted} old visitor records (older than 30 days)");
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to cleanup old visitors: ' . $e->getMessage());
            // Don't throw - allow request to continue
        }
    }
}
