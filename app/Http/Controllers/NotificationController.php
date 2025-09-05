<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->middleware('auth');
    }

    /**
     * Display notifications page
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $category = $request->get('category');
        $perPage = 15;

        $query = $user->roleNotifications();

        // Filter by category if specified
        if ($category) {
            $query->where('category', $category);
        }

        $notifications = $query->paginate($perPage);

        // Get unread count
        $unreadCount = $user->unread_notifications_count;

        // Get categories for filter
        $categories = [
            'all' => 'Tất cả',
            'order' => 'Đơn hàng',
            'payment' => 'Thanh toán',
            'promotion' => 'Khuyến mãi',
            'system' => 'Hệ thống',
            'marketing' => 'Marketing',
            'security' => 'Bảo mật',
        ];

        return view('notifications.index', compact('notifications', 'unreadCount', 'categories', 'category'));
    }

    /**
     * Get unread notifications count (AJAX)
     */
    public function getUnreadCount(): JsonResponse
    {
        $user = auth()->user();
        $count = $this->notificationService->getUnreadCount($user);

        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for dropdown (AJAX)
     */
    public function getRecentNotifications(): JsonResponse
    {
        $user = auth()->user();
        $notifications = $user->roleNotifications()
                              ->limit(5)
                              ->get();

        $unreadCount = $user->unread_notifications_count;

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id',
        ]);

        $user = auth()->user();
        $notificationId = $request->notification_id;

        $success = $this->notificationService->markAsRead($user, $notificationId);

        if ($success) {
            $unreadCount = $this->notificationService->getUnreadCount($user);
            return response()->json([
                'success' => true,
                'unreadCount' => $unreadCount,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể đánh dấu thông báo đã đọc',
        ], 400);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        $user = auth()->user();
        $count = $this->notificationService->markAllAsRead($user);

        return response()->json([
            'success' => true,
            'count' => $count,
            'unreadCount' => 0,
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id',
        ]);

        $user = auth()->user();
        $notificationId = $request->notification_id;

        // Remove the notification from user's notifications
        $user->roleNotifications()->detach($notificationId);

        $unreadCount = $this->notificationService->getUnreadCount($user);

        return response()->json([
            'success' => true,
            'unreadCount' => $unreadCount,
        ]);
    }

    /**
     * Clear all notifications
     */
    public function clearAll(): JsonResponse
    {
        $user = auth()->user();
        
        // Remove all notifications from user
        $user->roleNotifications()->detach();

        return response()->json([
            'success' => true,
            'unreadCount' => 0,
        ]);
    }
}
