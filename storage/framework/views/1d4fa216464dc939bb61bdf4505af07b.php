<?php $__env->startSection('title', 'Analytics'); ?>
<?php $__env->startSection('page-title', 'Analytics Dashboard'); ?>
<?php $__env->startSection('page-description', 'Visitor statistics and insights'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<style>
    .chart-container {
        position: relative;
        height: 300px;
    }
    #visitor-map {
        height: 400px;
        width: 100%;
        border-radius: 0.5rem;
        z-index: 0;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Visits</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="total-visits">-</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i data-feather="eye" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Unique Visitors</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="unique-visitors">-</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i data-feather="users" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Today's Visits</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="today-visits">-</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i data-feather="activity" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Visitor Map -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Visitor Locations</h3>
        <div id="visitor-map"></div>
        <p class="text-xs text-gray-500 mt-2" id="map-legend">Visitors with known location (from recent and real-time data).</p>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Visits Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Visits Over Time</h3>
            <div class="chart-container">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>

        <!-- Top Pages -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Top Pages</h3>
            <div class="chart-container">
                <canvas id="pagesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Visitors -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Recent Visitors</h3>
            <select id="filter-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="week">Last Week</option>
                <option value="month">Last Month</option>
                <option value="all">All Time</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Device</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Page</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                    </tr>
                </thead>
                <tbody id="visitors-table" class="divide-y divide-gray-200">
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Load analytics data
    function loadAnalytics() {
        fetch('/api/analytics', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update stats
                document.getElementById('total-visits').textContent = data.statistics.total_visits || 0;
                document.getElementById('unique-visitors').textContent = data.statistics.unique_visitors || 0;
                
                // Update today's visits (filter from recent visitors)
                const today = new Date().toISOString().split('T')[0];
                const todayVisits = data.recent_visitors.filter(v => v.visited_at_date === today).length;
                document.getElementById('today-visits').textContent = todayVisits;

                // Render charts
                renderVisitsChart(data.statistics.visits_by_day);
                renderPagesChart(data.statistics.top_pages);
                renderVisitorsTable(data.recent_visitors);
                // Build map points (recent + realtime with coords)
                const mapVisitors = [];
                (data.recent_visitors || []).forEach(v => {
                    if (v.latitude != null && v.longitude != null) mapVisitors.push(v);
                });
                (data.realtime_visitors || []).forEach(v => {
                    if (v.latitude != null && v.longitude != null && !mapVisitors.find(m => m.id === v.id)) mapVisitors.push(v);
                });
                renderVisitorMap(mapVisitors);
            }
        })
        .catch(error => {
            console.error('Error loading analytics:', error);
            document.getElementById('visitors-table').innerHTML = 
                '<tr><td colspan="5" class="px-4 py-8 text-center text-red-500">Error loading data. Make sure Visitor model exists.</td></tr>';
        });
    }

    function renderVisitsChart(data) {
        const ctx = document.getElementById('visitsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(d => d.date),
                datasets: [{
                    label: 'Visits',
                    data: data.map(d => d.visits),
                    borderColor: '#937237',
                    backgroundColor: 'rgba(147, 114, 55, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    function renderPagesChart(data) {
        const ctx = document.getElementById('pagesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(d => d.page),
                datasets: [{
                    label: 'Visits',
                    data: data.map(d => d.visits),
                    backgroundColor: '#937237'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    function renderVisitorMap(visitors) {
        const mapEl = document.getElementById('visitor-map');
        if (!mapEl) return;
        // Clear previous map
        mapEl._leafletMap?.remove();
        const withCoords = (visitors || []).filter(v => v.latitude != null && v.longitude != null);
        if (withCoords.length === 0) {
            mapEl.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 bg-gray-50 rounded-lg">No visitor locations available yet.</div>';
            return;
        }
        const map = L.map('visitor-map').setView([20, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        const bounds = [];
        withCoords.forEach(v => {
            const lat = parseFloat(v.latitude);
            const lng = parseFloat(v.longitude);
            if (isNaN(lat) || isNaN(lng)) return;
            const label = [v.city, v.country].filter(Boolean).join(', ') || v.ip_address || 'Visitor';
            const popup = `<strong>${label}</strong><br>${v.ip_address || ''}<br>${v.visited_at_human || ''}`;
            L.marker([lat, lng]).addTo(map).bindPopup(popup);
            bounds.push([lat, lng]);
        });
        if (bounds.length === 1) {
            map.setView(bounds[0], 6);
        } else if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [30, 30], maxZoom: 12 });
        }
        mapEl._leafletMap = map;
    }

    function renderVisitorsTable(visitors) {
        const tbody = document.getElementById('visitors-table');
        if (visitors.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No visitors found</td></tr>';
            return;
        }

        tbody.innerHTML = visitors.map(visitor => `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-900">${visitor.ip_address}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${visitor.city || 'Unknown'}, ${visitor.country || 'Unknown'}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${visitor.device_type || 'Unknown'}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${visitor.url || '-'}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${visitor.visited_at_human || visitor.visited_at}</td>
            </tr>
        `).join('');
    }

    // Filter change handler
    document.getElementById('filter-date').addEventListener('change', function() {
        const filter = this.value;
        fetch(`/api/analytics?filter_date=${filter}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderVisitorsTable(data.recent_visitors);
                const mapVisitors = [];
                (data.recent_visitors || []).forEach(v => {
                    if (v.latitude != null && v.longitude != null) mapVisitors.push(v);
                });
                (data.realtime_visitors || []).forEach(v => {
                    if (v.latitude != null && v.longitude != null && !mapVisitors.find(m => m.id === v.id)) mapVisitors.push(v);
                });
                renderVisitorMap(mapVisitors);
            }
        });
    });

    // Load on page load
    loadAnalytics();
    feather.replace();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard/analytics.blade.php ENDPATH**/ ?>