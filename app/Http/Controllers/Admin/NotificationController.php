<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
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
        $this->middleware('admin');
    }

    /**
     * Display admin notifications page
     */
    public function index(Request $request)
    {
        $category = $request->get('category');
        $type = $request->get('type', 'admin');
        $perPage = 20;

        $query = Notification::query();

        // Filter by type (admin/customer)
        if ($type) {
            $query->where('type', $type);
        }

        // Filter by category if specified
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $notifications = $query->orderBy('created_at', 'desc')
                               ->paginate($perPage);

        // Get unread count for admin
        $user = auth()->user();
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

        // Get types for filter
        $types = [
            'admin' => 'Quản trị viên',
            'customer' => 'Khách hàng',
        ];

        return view('admin.notifications.index', compact(
            'notifications',
            'unreadCount',
            'categories',
            'types',
            'category',
            'type'
        ));
    }

    /**
     * Create new notification
     */
    public function create()
    {
        $categories = [
            'order' => 'Đơn hàng',
            'payment' => 'Thanh toán',
            'promotion' => 'Khuyến mãi',
            'system' => 'Hệ thống',
            'marketing' => 'Marketing',
            'security' => 'Bảo mật',
        ];

        $types = [
            'admin' => 'Quản trị viên',
            'customer' => 'Khách hàng',
        ];

        $colors = [
            'blue' => 'Xanh dương',
            'green' => 'Xanh lá',
            'red' => 'Đỏ',
            'yellow' => 'Vàng',
            'purple' => 'Tím',
            'orange' => 'Cam',
        ];

        $icons = [
            'bell' => 'Chuông',
            'shopping-cart' => 'Giỏ hàng',
            'credit-card' => 'Thẻ tín dụng',
            'gift' => 'Quà tặng',
            'alert' => 'Cảnh báo',
            'check' => 'Thành công',
            'x' => 'Hủy',
            'truck' => 'Vận chuyển',
            'star' => 'Sao',
            'heart' => 'Tim',
            'user' => 'Người dùng',
            'shield' => 'Bảo mật',
        ];

        return view('admin.notifications.create', compact('categories', 'types', 'colors', 'icons'));
    }

    /**
     * Store new notification
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:admin,customer',
            'category' => 'required|in:order,payment,promotion,system,marketing,security',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'icon' => 'nullable|string',
            'color' => 'required|in:blue,green,red,yellow,purple,orange',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string|max:100',
            'is_important' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
            'send_to' => 'required|in:all_customers,all_admins,specific_users',
            'user_ids' => 'required_if:send_to,specific_users|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $notification = $this->notificationService->createNotification([
            'type' => $request->type,
            'category' => $request->category,
            'title' => $request->title,
            'message' => $request->message,
            'icon' => $request->icon,
            'color' => $request->color,
            'action_url' => $request->action_url,
            'action_text' => $request->action_text,
            'is_important' => $request->boolean('is_important'),
            'expires_at' => $request->expires_at,
        ]);

        // Send to users based on selection
        switch ($request->send_to) {
            case 'all_customers':
                $this->notificationService->sendToAllCustomers($notification);
                break;
            case 'all_admins':
                $this->notificationService->sendToAllAdmins($notification);
                break;
            case 'specific_users':
                $this->notificationService->sendToUsers($notification, $request->user_ids);
                break;
        }

        return redirect()->route('admin.notifications.index')
                         ->with('success', 'Thông báo đã được tạo và gửi thành công!');
    }

    /**
     * Show notification details
     */
    public function show(Notification $notification)
    {
        $users = $notification->users()->paginate(20);
        
        return view('admin.notifications.show', compact('notification', 'users'));
    }

    /**
     * Edit notification
     */
    public function edit(Notification $notification)
    {
        $categories = [
            'order' => 'Đơn hàng',
            'payment' => 'Thanh toán',
            'promotion' => 'Khuyến mãi',
            'system' => 'Hệ thống',
            'marketing' => 'Marketing',
            'security' => 'Bảo mật',
        ];

        $types = [
            'admin' => 'Quản trị viên',
            'customer' => 'Khách hàng',
        ];

        $colors = [
            'blue' => 'Xanh dương',
            'green' => 'Xanh lá',
            'red' => 'Đỏ',
            'yellow' => 'Vàng',
            'purple' => 'Tím',
            'orange' => 'Cam',
        ];

        $icons = [
            'bell' => 'Chuông',
            'shopping-cart' => 'Giỏ hàng',
            'credit-card' => 'Thẻ tín dụng',
            'gift' => 'Quà tặng',
            'alert' => 'Cảnh báo',
            'check' => 'Thành công',
            'x' => 'Hủy',
            'truck' => 'Vận chuyển',
            'star' => 'Sao',
            'heart' => 'Tim',
            'user' => 'Người dùng',
            'shield' => 'Bảo mật',
        ];

        return view('admin.notifications.edit', compact('notification', 'categories', 'types', 'colors', 'icons'));
    }

    /**
     * Update notification
     */
    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'type' => 'required|in:admin,customer',
            'category' => 'required|in:order,payment,promotion,system,marketing,security',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'icon' => 'nullable|string',
            'color' => 'required|in:blue,green,red,yellow,purple,orange',
            'action_url' => 'nullable|url',
            'action_text' => 'nullable|string|max:100',
            'is_important' => 'boolean',
            'expires_at' => 'nullable|date',
        ]);

        $notification->update([
            'type' => $request->type,
            'category' => $request->category,
            'title' => $request->title,
            'message' => $request->message,
            'icon' => $request->icon,
            'color' => $request->color,
            'action_url' => $request->action_url,
            'action_text' => $request->action_text,
            'is_important' => $request->boolean('is_important'),
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('admin.notifications.index')
                         ->with('success', 'Thông báo đã được cập nhật thành công!');
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
                         ->with('success', 'Thông báo đã được xóa thành công!');
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
}
