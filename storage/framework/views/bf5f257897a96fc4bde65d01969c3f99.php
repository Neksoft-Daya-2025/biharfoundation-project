

<?php $__env->startSection('title', 'Customers'); ?>
<?php $__env->startSection('page-title', 'Customer Management'); ?>
<?php $__env->startSection('page-description', 'View and manage customer data'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Customers</h2>
            <p class="text-sm text-gray-600 mt-1">Manage customer information from orders</p>
        </div>
        <button onclick="exportCustomers()" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="download" class="w-4 h-4"></i>
            Export CSV
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Customers</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="total-customers">-</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i data-feather="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">From reservations</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="reservation-customers">-</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                    <i data-feather="calendar" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Order Customers</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2" id="order-customers">-</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i data-feather="shopping-bag" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Customer List</h3>
            <div class="flex items-center gap-4">
                <input type="text" id="search-customers" placeholder="Search customers..." 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"
                    onkeyup="filterCustomers()">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reservations</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orders</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Activity</th>
                    </tr>
                </thead>
                <tbody id="customers-table" class="divide-y divide-gray-200">
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">Loading customers...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="no-customers" class="hidden px-4 py-8 text-center text-gray-500">
            <i data-feather="users" class="w-12 h-12 mx-auto mb-2 text-gray-400"></i>
            <p>No customers found. Customers will appear here once orders are created.</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const currencySymbol = <?php echo json_encode(currency_symbol(), 15, 512) ?>;
    let allCustomers = [];

    // Load customers
    function loadCustomers() {
        fetch('/api/customers', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allCustomers = data.data || [];
                updateStats(allCustomers);
                renderCustomersTable(allCustomers);
            } else {
                document.getElementById('customers-table').innerHTML = 
                    '<tr><td colspan="8" class="px-4 py-8 text-center text-red-500">Error loading customers</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error loading customers:', error);
            document.getElementById('customers-table').innerHTML = 
                '<tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">No customer models found (Reservation/Order models may not exist yet)</td></tr>';
        });
    }

    // Update statistics
    function updateStats(customers) {
        const total = customers.length;
        const reservationCount = customers.filter(c => c.customer_type === 'Reservation' || c.customer_type === 'Both').length;
        const orderCount = customers.filter(c => c.customer_type === 'Takeaway' || c.customer_type === 'Order' || c.customer_type === 'Both').length;

        document.getElementById('total-customers').textContent = total;
        document.getElementById('reservation-customers').textContent = reservationCount;
        document.getElementById('order-customers').textContent = orderCount;
    }

    // Render customers table
    function renderCustomersTable(customers) {
        const tbody = document.getElementById('customers-table');
        const noCustomers = document.getElementById('no-customers');

        if (customers.length === 0) {
            tbody.innerHTML = '';
            noCustomers.classList.remove('hidden');
            return;
        }

        noCustomers.classList.add('hidden');
        tbody.innerHTML = customers.map(customer => {
            const typeBadge = customer.customer_type === 'Both'
                ? '<span class="status-badge bg-purple-100 text-purple-800">Both</span>'
                : customer.customer_type === 'Reservation'
                ? '<span class="status-badge bg-blue-100 text-blue-800">Reservation</span>'
                : customer.customer_type === 'Order'
                ? '<span class="status-badge bg-green-100 text-green-800">Order</span>'
                : '<span class="status-badge bg-green-100 text-green-800">Takeaway</span>';

            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-900">${customer.name || '-'}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${customer.email}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${customer.phone || '-'}</td>
                    <td class="px-4 py-3 text-sm">${typeBadge}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${customer.reservation_count || 0}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${customer.order_count || 0}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${currencySymbol}${parseFloat(customer.total_orders_value || 0).toFixed(2)}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">${customer.last_activity ? new Date(customer.last_activity).toLocaleDateString() : '-'}</td>
                </tr>
            `;
        }).join('');
    }

    // Filter customers
    function filterCustomers() {
        const searchTerm = document.getElementById('search-customers').value.toLowerCase();
        const filtered = allCustomers.filter(customer => {
            return (customer.name && customer.name.toLowerCase().includes(searchTerm)) ||
                   (customer.email && customer.email.toLowerCase().includes(searchTerm)) ||
                   (customer.phone && customer.phone.includes(searchTerm));
        });
        renderCustomersTable(filtered);
    }

    // Export customers to CSV
    function exportCustomers() {
        window.location.href = '/api/customers/export';
    }

    // Load on page load
    loadCustomers();
    feather.replace();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard/customers.blade.php ENDPATH**/ ?>