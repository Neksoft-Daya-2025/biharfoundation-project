<?php $__env->startSection('title', 'Orders'); ?>
<?php $__env->startSection('page-title', 'Orders'); ?>
<?php $__env->startSection('page-description', 'View and manage orders'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-paid { background: #d1fae5; color: #065f46; }
    .status-processing { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
    .payment-paid { background: #d1fae5; color: #065f46; }
    .payment-pending { background: #fef3c7; color: #92400e; }
    .payment-failed { background: #fee2e2; color: #991b1b; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Orders</h2>
            <p class="text-sm text-gray-600 mt-1">All orders with status and payment info</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <input type="text" id="search-orders" placeholder="Search by order #, name, email..."
                class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none w-64">
            <select id="filter-status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
                <option value="">All statuses</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select id="filter-payment" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
                <option value="">All payments</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="failed">Failed</option>
            </select>
            <button type="button" onclick="loadOrders()" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="search" class="w-4 h-4"></i>
                Apply
            </button>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order #</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody id="orders-tbody" class="divide-y divide-gray-200 bg-white">
                    <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        <div id="orders-pagination" class="px-6 py-4 border-t border-gray-200 flex items-center justify-between"></div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    let currentPage = 1;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const currencySymbol = <?php echo json_encode(currency_symbol(), 15, 512) ?>;
    function formatMoney(n) { return currencySymbol + parseFloat(n).toFixed(2); }

    function statusClass(s) {
        const m = { pending: 'status-pending', paid: 'status-paid', processing: 'status-processing', completed: 'status-completed', cancelled: 'status-cancelled' };
        return m[s] || 'status-pending';
    }
    function paymentClass(p) {
        const m = { paid: 'payment-paid', pending: 'payment-pending', failed: 'payment-failed' };
        return m[p] || 'payment-pending';
    }

    function loadOrders(page = 1) {
        currentPage = page;
        const search = document.getElementById('search-orders').value.trim();
        const status = document.getElementById('filter-status').value;
        const payment = document.getElementById('filter-payment').value;
        const params = new URLSearchParams({ page, per_page: 15 });
        if (search) params.set('search', search);
        if (status) params.set('status', status);
        if (payment) params.set('payment_status', payment);

        fetch('/api/orders?' + params.toString(), { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                const tbody = document.getElementById('orders-tbody');
                if (!data.data.length) {
                    tbody.innerHTML = '<tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">No orders found.</td></tr>';
                } else {
                    tbody.innerHTML = data.data.map(o => `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${o.order_number}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${o.customer_name}<br><span class="text-xs text-gray-400">${o.customer_email}</span></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${o.order_type || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap"><span class="status-badge ${statusClass(o.status)}">${o.status}</span></td>
                            <td class="px-6 py-4 whitespace-nowrap"><span class="status-badge ${paymentClass(o.payment_status)}">${o.payment_status}</span></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${formatMoney(o.total)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${o.created_at_human}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="<?php echo e(url('dashboard/orders')); ?>/${o.id}" class="text-[#937237] hover:underline">View</a>
                            </td>
                        </tr>
                    `).join('');
                }
                const pag = data.pagination;
                const pagEl = document.getElementById('orders-pagination');
                if (pag.last_page <= 1) pagEl.innerHTML = '';
                else {
                    const cur = pag.current_page;
                    const last = pag.last_page;
                    const pageNums = [];
                    const add = (p) => { if (p >= 1 && p <= last && !pageNums.includes(p)) pageNums.push(p); };
                    add(1);
                    for (let p = Math.max(1, cur - 2); p <= Math.min(last, cur + 2); p++) add(p);
                    if (last > 1) add(last);
                    pageNums.sort((a, b) => a - b);
                    const parts = [];
                    let prev = 0;
                    for (const p of pageNums) {
                        if (prev && p > prev + 1) parts.push('…');
                        parts.push(p);
                        prev = p;
                    }
                    const pageLinks = parts.map(p => p === '…' ? '<span class="px-2 text-gray-400">…</span>' : `<button onclick="loadOrders(${p})" class="min-w-[2rem] px-2 py-1 rounded-lg text-sm ${p === cur ? 'bg-[#937237] text-white' : 'border border-gray-300 hover:bg-gray-100'}">${p}</button>`).join('');
                    pagEl.innerHTML = `
                        <span class="text-sm text-gray-600">Page ${pag.current_page} of ${pag.last_page} (${pag.total} total)</span>
                        <div class="flex items-center gap-1 flex-wrap">
                            ${pag.current_page > 1 ? `<button onclick="loadOrders(${pag.current_page - 1})" class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">Previous</button>` : ''}
                            <div class="flex items-center gap-1">${pageLinks}</div>
                            ${pag.current_page < pag.last_page ? `<button onclick="loadOrders(${pag.current_page + 1})" class="px-3 py-1 border rounded-lg text-sm hover:bg-gray-100">Next</button>` : ''}
                        </div>
                    `;
                }
                if (typeof feather !== 'undefined') feather.replace();
            })
            .catch(() => {
                document.getElementById('orders-tbody').innerHTML = '<tr><td colspan="8" class="px-6 py-8 text-center text-red-500">Failed to load orders.</td></tr>';
            });
    }

    document.getElementById('search-orders').addEventListener('keydown', function(e) { if (e.key === 'Enter') loadOrders(1); });
    document.getElementById('filter-status').addEventListener('change', () => loadOrders(1));
    document.getElementById('filter-payment').addEventListener('change', () => loadOrders(1));
    loadOrders(1);
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MUGDHA\Downloads\New folder\backend-project-main\backend-project-main\resources\views/dashboard/orders.blade.php ENDPATH**/ ?>