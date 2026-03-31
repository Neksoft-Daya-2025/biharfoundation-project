@extends('layouts.dashboard')

@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order ' . $order->order_number)
@section('page-description', 'Order details and items')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard.orders') }}" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Order info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Order & Customer</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-gray-600">Order number</dt><dd class="font-medium">{{ $order->order_number }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Status</dt><dd><span class="px-2 py-1 rounded-full text-xs font-medium
                    @if($order->status === 'paid' || $order->status === 'completed') bg-green-100 text-green-800
                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-blue-100 text-blue-800
                    @endif">{{ $order->status }}</span></dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Payment</dt><dd><span class="px-2 py-1 rounded-full text-xs font-medium {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $order->payment_status }}</span></dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Customer</dt><dd class="font-medium">{{ $order->customer_name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Email</dt><dd>{{ $order->customer_email }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Phone</dt><dd>{{ $order->customer_phone ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Order type</dt><dd>{{ $order->order_type ?? '-' }}</dd></div>
                @if($order->delivery_address)
                <div class="flex justify-between"><dt class="text-gray-600">Address</dt><dd>{{ $order->delivery_address }}</dd></div>
                @endif
                @if($order->delivery_time)
                <div class="flex justify-between"><dt class="text-gray-600">Delivery time</dt><dd>{{ $order->delivery_time->format('d M Y H:i') }}</dd></div>
                @endif
                @if($order->notes)
                <div class="flex justify-between"><dt class="text-gray-600">Notes</dt><dd>{{ $order->notes }}</dd></div>
                @endif
                <div class="flex justify-between"><dt class="text-gray-600">Created</dt><dd>{{ $order->created_at->format('d M Y H:i') }}</dd></div>
            </dl>

            @if(in_array($order->status, ['pending', 'paid', 'processing', 'completed', 'cancelled']))
            <div class="mt-4 pt-4 border-t border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Update status</label>
                <form id="update-status-form" class="flex gap-2">
                    @csrf
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg text-sm font-medium">Update</button>
                </form>
            </div>
            @endif
        </div>

        <!-- Totals -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Totals</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-600">Subtotal</dt><dd>{{ format_money($order->subtotal) }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-600">Delivery fee</dt><dd>{{ format_money($order->delivery_fee) }}</dd></div>
                <div class="flex justify-between text-base font-bold pt-2 border-t"><dt>Total</dt><dd>{{ format_money($order->total) }}</dd></div>
            </dl>
        </div>
    </div>

    <!-- Items -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <h3 class="text-lg font-bold text-gray-900 p-6 pb-0">Items</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">{{ $item->product_name }}</span>
                            @if($item->product_description)
                            <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($item->product_description, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ format_money($item->price) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-right">{{ format_money($item->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('update-status-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const fd = new FormData(form);
        const status = form.status && form.status.value ? form.status.value.trim() : '';
        if (!status) { alert('Please select a status.'); return; }
        fetch('{{ route("dashboard.orders.status", $order) }}', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json' },
            body: JSON.stringify({ status: status })
        }).then(r => r.json()).then(data => {
            if (data.success) { alert('Status updated.'); window.location.reload(); }
            else alert(data.message || 'Update failed.');
        }).catch(() => alert('Update failed.'));
    });
    if (typeof feather !== 'undefined') feather.replace();
</script>
@endpush
@endsection
