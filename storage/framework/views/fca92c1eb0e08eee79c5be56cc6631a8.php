<?php $__env->startSection('title', 'Attendees'); ?>
<?php $__env->startSection('page-title', 'Attendees Management'); ?>
<?php $__env->startSection('page-description', 'View and manage all event bookings and attendees'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Attendees</h2>
            <p class="text-sm text-gray-600 mt-1">All event ticket bookings</p>
        </div>
        <a href="<?php echo e(route('dashboard.events')); ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="calendar" class="w-4 h-4"></i> Events
        </a>
    </div>

    <form method="GET" action="<?php echo e(route('dashboard.events.attendees')); ?>" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <select name="event_id" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
                <option value="">All events</option>
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($e->id); ?>" <?php echo e(request('event_id') == $e->id ? 'selected' : ''); ?>><?php echo e($e->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
                <option value="">All statuses</option>
                <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="confirmed" <?php echo e(request('status') === 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="search" class="w-4 h-4"></i> Filter
            </button>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Attendee</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Booked at</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-sm text-gray-900"><?php echo e($booking->booking_reference); ?></td>
                        <td class="px-6 py-4 text-sm">
                            <a href="<?php echo e(route('dashboard.events.show', $booking->event)); ?>" class="text-[#937237] hover:underline"><?php echo e($booking->event->title); ?></a>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900"><?php echo e($booking->customer_name); ?></div>
                            <div class="text-gray-500"><?php echo e($booking->customer_email); ?></div>
                            <?php if($booking->customer_phone): ?><div class="text-gray-500 text-xs"><?php echo e($booking->customer_phone); ?></div><?php endif; ?>
                            <?php if($booking->items->isNotEmpty()): ?>
                            <div class="text-xs text-gray-500 mt-1">
                                <?php $__currentLoopData = $booking->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($item->ticketType->name ?? 'N/A'); ?>: <?php echo e($item->quantity); ?><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($booking->attendees_count); ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e(format_money($booking->total_amount)); ?></td>
                        <td class="px-6 py-4">
                            <?php if($booking->status === 'confirmed'): ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Confirmed</span>
                            <?php elseif($booking->status === 'cancelled'): ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Cancelled</span>
                            <?php else: ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-800">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($booking->created_at->format('d M Y H:i')); ?></td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="<?php echo e(route('dashboard.events.show', $booking->event)); ?>" class="text-[#937237] hover:underline">View event</a>
                            <?php if($booking->status !== 'cancelled'): ?>
                            <form action="<?php echo e(route('dashboard.events.bookings.update-status', $booking)); ?>" method="POST" class="inline ml-2">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="<?php echo e($booking->status === 'confirmed' ? 'pending' : 'confirmed'); ?>">
                                <button type="submit" class="text-[#937237] hover:underline"><?php echo e($booking->status === 'confirmed' ? 'Pending' : 'Confirm'); ?></button>
                            </form>
                            <form action="<?php echo e(route('dashboard.events.bookings.update-status', $booking)); ?>" method="POST" class="inline ml-2">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Cancel this booking?');">Cancel</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">No bookings found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($bookings->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($bookings->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>feather.replace();</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASUS\Desktop\laravel-backend\resources\views/dashboard/events/attendees.blade.php ENDPATH**/ ?>