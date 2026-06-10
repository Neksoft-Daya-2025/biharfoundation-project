@extends('layouts.dashboard')

@section('title', 'Notifications')
@section('page-title', 'Notification Management')
@section('page-description', 'View and manage all notifications')

@push('styles')
<style>
    .type-badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
    .type-order { background: #dbeafe; color: #1e40af; }
    .type-system { background: #e5e7eb; color: #374151; }
    .type-info { background: #d1fae5; color: #065f46; }
    .type-warning { background: #fef3c7; color: #92400e; }
    .type-success { background: #d1fae5; color: #047857; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Notifications</h2>
            <p class="text-sm text-gray-600 mt-1">Manage and clear notifications</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="markAllRead()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="check-circle" class="w-4 h-4"></i>
                Mark all read
            </button>
            <button type="button" onclick="clearRead()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="trash-2" class="w-4 h-4"></i>
                Clear read
            </button>
            <button type="button" onclick="clearAll()" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="x-circle" class="w-4 h-4"></i>
                Clear all
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Unread</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="unread-count">0</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                    <i data-feather="bell" class="w-6 h-6 text-amber-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="total-count">0</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i data-feather="inbox" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <span class="text-sm font-medium text-gray-700">Filter:</span>
            <select id="filter" onchange="loadNotifications()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                <option value="">All</option>
                <option value="unread">Unread</option>
                <option value="read">Read</option>
                <option value="order">Order</option>
                <option value="system">System</option>
                <option value="info">Info</option>
                <option value="warning">Warning</option>
                <option value="success">Success</option>
            </select>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-900">Notification List</h3>
        </div>
        <div id="notifications-list" class="space-y-3">
            <div class="text-center py-8 text-gray-500">Loading notifications...</div>
        </div>
        <div id="no-notifications" class="hidden text-center py-12 text-gray-500">
            <i data-feather="bell-off" class="w-12 h-12 mx-auto mb-2 text-gray-400"></i>
            <p>No notifications yet.</p>
        </div>
        <!-- Pagination -->
        <div id="pagination" class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4 hidden">
            <p class="text-sm text-gray-600" id="pagination-info"></p>
            <div class="flex gap-2" id="pagination-buttons"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentPage = 1;
    const perPage = 20;

    function getCsrf() {
        return document.querySelector('meta[name="csrf-token"]').content;
    }

    function typeClass(type) {
        const map = { order: 'type-order', system: 'type-system', info: 'type-info', warning: 'type-warning', success: 'type-success' };
        return map[type] || 'bg-gray-100 text-gray-800';
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function handleNotificationClick(event, id) {
        if (event.target.closest('button')) return;
        const link = event.currentTarget.dataset.link || '';
        if (typeof window.openNotification === 'function') {
            window.openNotification(id, link || null);
        }
    }

    function loadNotifications(page = 1) {
        currentPage = page;
        const filter = document.getElementById('filter').value;
        const params = new URLSearchParams({ page, per_page: perPage });
        if (filter) params.set('filter', filter);

        fetch('/api/notifications?' + params, {
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) return;
            const list = document.getElementById('notifications-list');
            const noNotif = document.getElementById('no-notifications');
            const pagination = document.getElementById('pagination');
            const paginationInfo = document.getElementById('pagination-info');
            const paginationButtons = document.getElementById('pagination-buttons');

            document.getElementById('unread-count').textContent = data.unread_count ?? 0;
            document.getElementById('total-count').textContent = data.pagination?.total ?? 0;
            window.syncNotificationBadges(data.unread_count ?? 0);

            if (!data.notifications || data.notifications.length === 0) {
                list.innerHTML = '';
                list.classList.add('hidden');
                noNotif.classList.remove('hidden');
                pagination.classList.add('hidden');
                return;
            }
            noNotif.classList.add('hidden');
            list.classList.remove('hidden');
            list.innerHTML = data.notifications.map(n => {
                const typeCls = typeClass(n.type);
                const readCls = n.is_read ? 'bg-gray-50 opacity-80' : 'bg-white border-amber-200';
                const link = (n.data && n.data.link) ? n.data.link : '';
                const viewAction = link
                    ? `<button type="button" onclick="event.stopPropagation(); window.openNotification(${n.id}, ${JSON.stringify(link)})" class="text-[#937237] hover:underline ml-1">View</button>`
                    : `<button type="button" onclick="event.stopPropagation(); window.openNotification(${n.id}, null)" class="text-[#937237] hover:underline ml-1">View details</button>`;
                return `
                    <div
                        class="border border-gray-200 rounded-lg p-4 ${readCls} cursor-pointer hover:bg-gray-50 transition-colors"
                        data-id="${n.id}"
                        data-link="${escapeHtml(link)}"
                        onclick="handleNotificationClick(event, ${n.id})"
                        role="button"
                        tabindex="0"
                        onkeydown="if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); handleNotificationClick(event, ${n.id}); }"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="type-badge ${typeCls}">${escapeHtml(n.type)}</span>
                                    ${!n.is_read ? '<span class="text-xs font-medium text-amber-600">New</span>' : ''}
                                    <span class="text-sm text-gray-500">${escapeHtml(n.created_at_human)}</span>
                                </div>
                                <h4 class="font-semibold text-gray-900 mt-1">${escapeHtml(n.title)}</h4>
                                ${n.message ? `<p class="text-sm text-gray-600 mt-1">${escapeHtml(n.message)}</p>` : ''}
                                ${viewAction}
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                ${!n.is_read ? `<button type="button" onclick="event.stopPropagation(); markRead(${n.id})" class="p-2 text-gray-500 hover:text-[#937237] hover:bg-gray-100 rounded-lg" title="Mark as read"><i data-feather="check" class="w-4 h-4"></i></button>` : ''}
                                <button type="button" onclick="event.stopPropagation(); deleteNotification(${n.id})" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Delete"><i data-feather="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            feather.replace();

            if (data.pagination && data.pagination.last_page > 1) {
                pagination.classList.remove('hidden');
                paginationInfo.textContent = `Page ${data.pagination.current_page} of ${data.pagination.last_page} (${data.pagination.total} total)`;
                let btns = '';
                if (data.pagination.current_page > 1) {
                    btns += `<button type="button" onclick="loadNotifications(${data.pagination.current_page - 1})" class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Previous</button>`;
                }
                if (data.pagination.current_page < data.pagination.last_page) {
                    btns += `<button type="button" onclick="loadNotifications(${data.pagination.current_page + 1})" class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Next</button>`;
                }
                paginationButtons.innerHTML = btns;
            } else {
                pagination.classList.add('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('notifications-list').innerHTML = '<div class="text-center py-8 text-red-500">Error loading notifications.</div>';
        });
    }

    function markRead(id) {
        window.markNotificationRead(id)
        .then(data => { if (data.success) loadNotifications(currentPage); })
        .catch(() => {});
    }

    function markAllRead() {
        fetch('/api/notifications/read-all', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.syncNotificationBadges(data.unread_count ?? 0);
                loadNotifications(currentPage);
            }
        })
        .catch(() => {});
    }

    function deleteNotification(id) {
        if (!confirm('Delete this notification?')) return;
        fetch(`/api/notifications/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.syncNotificationBadges(data.unread_count ?? 0);
                loadNotifications(currentPage);
            }
        })
        .catch(() => {});
    }

    function clearRead() {
        if (!confirm('Delete all read notifications?')) return;
        fetch('/api/notifications/clear/read', {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => { if (data.success) loadNotifications(1); })
        .catch(() => {});
    }

    function clearAll() {
        if (!confirm('Delete ALL notifications? This cannot be undone.')) return;
        fetch('/api/notifications/clear/all', {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => { if (data.success) loadNotifications(1); })
        .catch(() => {});
    }

    loadNotifications(1);
    feather.replace();
</script>
@endpush
