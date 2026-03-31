<?php

namespace App\Http\Controllers;

use App\Models\Notification as NotificationModel;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Show notifications management page
     */
    public function index(Request $request)
    {
        return view('dashboard.notifications');
    }

    /**
     * API: List notifications with filters and pagination
     */
    public function api(Request $request)
    {
        $query = NotificationModel::orderBy('created_at', 'desc');

        if ($request->filled('filter')) {
            if ($request->filter === 'unread') {
                $query->unread();
            } elseif ($request->filter === 'read') {
                $query->read();
            } elseif (in_array($request->filter, ['order', 'system', 'info', 'warning', 'success'])) {
                $query->ofType($request->filter);
            }
        }

        $perPage = max(5, min(100, (int) $request->get('per_page', 20)));
        $notifications = $query->paginate($perPage);

        $unreadCount = NotificationModel::unread()->count();

        $items = $notifications->getCollection()->map(function ($n) {
            return [
                'id' => $n->id,
                'type' => $n->type,
                'title' => $n->title,
                'message' => $n->message,
                'data' => $n->data,
                'read_at' => $n->read_at?->toIso8601String(),
                'created_at' => $n->created_at->format('Y-m-d H:i:s'),
                'created_at_human' => $n->created_at->diffForHumans(),
                'is_read' => $n->isRead(),
            ];
        });

        return response()->json([
            'success' => true,
            'notifications' => $items,
            'unread_count' => $unreadCount,
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    /**
     * API: Get unread count only (for header badge)
     */
    public function unreadCount()
    {
        $count = NotificationModel::unread()->count();
        return response()->json(['success' => true, 'unread_count' => $count]);
    }

    /**
     * Mark a single notification as read
     */
    public function markRead(NotificationModel $notification)
    {
        $notification->markAsRead();
        return response()->json(['success' => true, 'message' => 'Marked as read.']);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead()
    {
        NotificationModel::unread()->update(['read_at' => now()]);
        return response()->json(['success' => true, 'message' => 'All notifications marked as read.']);
    }

    /**
     * Delete a single notification
     */
    public function destroy(NotificationModel $notification)
    {
        $notification->delete();
        return response()->json(['success' => true, 'message' => 'Notification deleted.']);
    }

    /**
     * Delete all read notifications (or all if confirmed)
     */
    public function clearRead(Request $request)
    {
        $deleted = NotificationModel::read()->delete();
        return response()->json(['success' => true, 'message' => "{$deleted} notification(s) deleted.", 'deleted' => $deleted]);
    }

    /**
     * Delete all notifications
     */
    public function clearAll()
    {
        $deleted = NotificationModel::count();
        NotificationModel::query()->delete();
        return response()->json(['success' => true, 'message' => "All {$deleted} notification(s) deleted.", 'deleted' => $deleted]);
    }
}
