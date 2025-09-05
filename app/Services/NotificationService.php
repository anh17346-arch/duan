<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Review;

class NotificationService
{
    /**
     * Create a new notification
     */
    public function createNotification(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Send notification to specific users
     */
    public function sendToUsers(Notification $notification, array $userIds): void
    {
        // Remove duplicates and filter out invalid user IDs
        $userIds = array_unique(array_filter($userIds));
        
        if (empty($userIds)) {
            return;
        }
        
        // Use syncWithoutDetaching to avoid duplicate entries
        $notification->users()->syncWithoutDetaching($userIds);
        
        // Send email notifications if needed
        $this->sendEmailNotifications($notification, $userIds);
    }

    /**
     * Send notification to all customers
     */
    public function sendToAllCustomers(Notification $notification): void
    {
        $customerIds = User::where('role', 'customer')->pluck('id')->toArray();
        $this->sendToUsers($notification, $customerIds);
    }

    /**
     * Send notification to all admins
     */
    public function sendToAllAdmins(Notification $notification): void
    {
        $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
        $this->sendToUsers($notification, $adminIds);
    }

    /**
     * Send notification to all users
     */
    public function sendToAllUsers(Notification $notification): void
    {
        $userIds = User::pluck('id')->toArray();
        $this->sendToUsers($notification, $userIds);
    }

    // ==================== CUSTOMER NOTIFICATIONS ====================

    /**
     * Create registration & login notifications
     */
    public function createAuthNotification(User $user, string $type, array $data = []): void
    {
        $notificationData = $this->getAuthNotificationData($user, $type, $data);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            $this->sendToUsers($notification, [$user->id]);
        }
    }

    /**
     * Create order notification
     */
    public function createOrderNotification(Order $order, $status)
    {
        $statusMessages = [
            'new' => 'Đơn hàng #' . $order->order_number . ' đã được đặt thành công',
            'processing' => 'Đơn hàng #' . $order->order_number . ' đang được xử lý',
            'shipped' => 'Đơn hàng #' . $order->order_number . ' đã được vận chuyển',
            'delivered' => 'Đơn hàng #' . $order->order_number . ' đã được giao thành công',
            'cancelled' => 'Đơn hàng #' . $order->order_number . ' đã bị hủy'
        ];

        $statusTitles = [
            'new' => 'Đặt hàng thành công',
            'processing' => 'Đơn hàng đang xử lý',
            'shipped' => 'Đơn hàng đã vận chuyển',
            'delivered' => 'Đơn hàng đã giao',
            'cancelled' => 'Đơn hàng bị hủy'
        ];

        // Create notification for customer
        $notification = Notification::create([
            'type' => 'order_status',
            'title' => $statusTitles[$status] ?? 'Cập nhật đơn hàng',
            'message' => $statusMessages[$status] ?? 'Đơn hàng của bạn đã được cập nhật',
            'data' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $status,
                'total' => $order->total
            ]
        ]);

        // Send to customer
        $order->user->notifications()->attach($notification->id, [
            'is_read' => false,
            'created_at' => now()
        ]);

        // If it's a new order, also notify admin
        if ($status === 'new') {
            $adminNotification = Notification::create([
                'type' => 'new_order',
                'title' => 'Đơn hàng mới',
                'message' => "Có đơn hàng mới #{$order->order_number} từ khách hàng {$order->user->name}",
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->user->name,
                    'total' => $order->total
                ]
            ]);

            // Send to all admin users
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notifications()->attach($adminNotification->id, [
                    'is_read' => false,
                    'created_at' => now()
                ]);
            }
        }
    }

    /**
     * Create payment notification
     */
    public function createPaymentNotification(Order $order, string $type): void
    {
        $notificationData = $this->getPaymentNotificationData($order, $type);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            
            // Send to customer only
            $this->sendToUsers($notification, [$order->user_id]);
            
            // Create separate admin notification for certain types
            if (in_array($type, ['success', 'failed', 'refunded'])) {
                $this->createAdminPaymentNotification($order, $type);
            }
        }
    }

    /**
     * Create promotion notification
     */
    public function createPromotionNotification(Promotion $promotion, string $type): void
    {
        $notificationData = $this->getPromotionNotificationData($promotion, $type);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            
            // Send to all customers for marketing promotions
            if ($type === 'flash_sale' || $type === 'new_promotion') {
                $this->sendToAllCustomers($notification);
            }
        }
    }

    /**
     * Create account update notification
     */
    public function createAccountNotification(User $user, string $type): void
    {
        $notificationData = $this->getAccountNotificationData($user, $type);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            $this->sendToUsers($notification, [$user->id]);
        }
    }

    /**
     * Create cart reminder notification
     */
    public function createCartReminderNotification(User $user): void
    {
        $cartItems = $user->cart()->with('product')->get();
        
        if ($cartItems->isNotEmpty()) {
            $notificationData = [
                'type' => Notification::TYPE_CUSTOMER,
                'category' => Notification::CATEGORY_MARKETING,
                'title' => 'Giỏ hàng của bạn đang chờ',
                'message' => "Bạn có {$cartItems->count()} sản phẩm trong giỏ hàng. Hoàn tất đơn hàng để nhận ưu đãi!",
                'icon' => Notification::ICON_SHOPPING_CART,
                'color' => Notification::COLOR_BLUE,
                'action_url' => route('cart.index'),
                'action_text' => 'Xem giỏ hàng',
                'data' => [
                    'cart_items_count' => $cartItems->count(),
                    'cart_total' => $cartItems->sum('subtotal'),
                ],
            ];

            $notification = $this->createNotification($notificationData);
            $this->sendToUsers($notification, [$user->id]);
        }
    }

    /**
     * Create product recommendation notification
     */
    public function createProductRecommendationNotification(User $user, Product $product, string $reason = 'new'): void
    {
        $notificationData = [
            'type' => Notification::TYPE_CUSTOMER,
            'category' => Notification::CATEGORY_MARKETING,
            'title' => 'Sản phẩm mới dành cho bạn',
            'message' => "Sản phẩm {$product->name} có thể phù hợp với sở thích của bạn!",
            'icon' => Notification::ICON_HEART,
            'color' => Notification::COLOR_PURPLE,
            'action_url' => route('products.show', $product),
            'action_text' => 'Xem sản phẩm',
            'data' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'reason' => $reason,
            ],
        ];

        $notification = $this->createNotification($notificationData);
        $this->sendToUsers($notification, [$user->id]);
    }

    // ==================== ADMIN NOTIFICATIONS ====================

    /**
     * Create admin-specific order notification
     */
    public function createAdminOrderNotification(Order $order, string $type): void
    {
        $notificationData = $this->getAdminOrderNotificationData($order, $type);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            $this->sendToAllAdmins($notification);
        }
    }

    /**
     * Create admin-specific payment notification
     */
    public function createAdminPaymentNotification(Order $order, string $type): void
    {
        $notificationData = $this->getAdminPaymentNotificationData($order, $type);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            $this->sendToAllAdmins($notification);
        }
    }

    /**
     * Create inventory notification
     */
    public function createInventoryNotification(Product $product, string $type): void
    {
        $notificationData = $this->getInventoryNotificationData($product, $type);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            $this->sendToAllAdmins($notification);
        }
    }

    /**
     * Create security notification
     */
    public function createSecurityNotification(User $user, string $type, array $data = []): void
    {
        $notificationData = $this->getSecurityNotificationData($user, $type, $data);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            $this->sendToAllAdmins($notification);
        }
    }

    /**
     * Create business notification
     */
    public function createBusinessNotification(string $type, array $data = []): void
    {
        $notificationData = $this->getBusinessNotificationData($type, $data);
        
        if ($notificationData) {
            $notification = $this->createNotification($notificationData);
            $this->sendToAllAdmins($notification);
        }
    }

    /**
     * Create customer VIP upgrade notification
     */
    public function createCustomerVIPNotification(User $user, string $newType): void
    {
        $notificationData = [
            'type' => Notification::TYPE_ADMIN,
            'category' => Notification::CATEGORY_SYSTEM,
            'title' => 'Khách hàng VIP mới',
            'message' => "Khách hàng {$user->name} đã được nâng cấp lên {$newType}",
            'icon' => Notification::ICON_STAR,
            'color' => Notification::COLOR_PURPLE,
            'action_url' => route('admin.customers.show', $user),
            'action_text' => 'Xem chi tiết',
            'data' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'new_customer_type' => $newType,
            ],
        ];

        $notification = $this->createNotification($notificationData);
        $this->sendToAllAdmins($notification);
    }

    /**
     * Create customer support request notification
     */
    public function createSupportRequestNotification(User $user, string $subject, string $message): void
    {
        $notificationData = [
            'type' => Notification::TYPE_ADMIN,
            'category' => Notification::CATEGORY_SYSTEM,
            'title' => 'Yêu cầu hỗ trợ khách hàng',
            'message' => "Khách hàng {$user->name} gửi yêu cầu hỗ trợ: {$subject}",
            'icon' => Notification::ICON_ALERT,
            'color' => Notification::COLOR_ORANGE,
            'action_url' => route('admin.customers.show', $user),
            'action_text' => 'Phản hồi',
            'data' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'subject' => $subject,
                'message' => $message,
            ],
            'is_important' => true,
        ];

        $notification = $this->createNotification($notificationData);
        $this->sendToAllAdmins($notification);
    }

    /**
     * Create order processing delay notification
     */
    public function createOrderProcessingDelayNotification(Order $order): void
    {
        $hoursSinceCreated = $order->created_at->diffInHours(now());
        
        if ($hoursSinceCreated >= 24) {
            $notificationData = [
                'type' => Notification::TYPE_ADMIN,
                'category' => Notification::CATEGORY_ORDER,
                'title' => 'Đơn hàng chờ xử lý quá lâu',
                'message' => "Đơn hàng #{$order->order_number} đã chờ xử lý {$hoursSinceCreated} giờ",
                'icon' => Notification::ICON_CLOCK,
                'color' => Notification::COLOR_RED,
                'action_url' => route('admin.orders.show', $order),
                'action_text' => 'Xử lý ngay',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'hours_delayed' => $hoursSinceCreated,
                ],
                'is_important' => true,
            ];

            $notification = $this->createNotification($notificationData);
            $this->sendToAllAdmins($notification);
        }
    }

    /**
     * Create promotion expiry notification
     */
    public function createPromotionExpiryNotification(Promotion $promotion): void
    {
        $hoursUntilExpiry = $promotion->end_date->diffInHours(now());
        
        if ($hoursUntilExpiry <= 1) {
            $notificationData = [
                'type' => Notification::TYPE_ADMIN,
                'category' => Notification::CATEGORY_PROMOTION,
                'title' => 'Khuyến mãi sắp hết hạn',
                'message' => "Khuyến mãi cho sản phẩm {$promotion->product->name} sẽ hết hạn trong {$hoursUntilExpiry} giờ",
                'icon' => Notification::ICON_CLOCK,
                'color' => Notification::COLOR_RED,
                'action_url' => route('admin.dashboard'),
                'action_text' => 'Xem chi tiết',
                'data' => [
                    'promotion_id' => $promotion->id,
                    'product_name' => $promotion->product->name,
                    'hours_until_expiry' => $hoursUntilExpiry,
                ],
                'is_important' => true,
            ];

            $notification = $this->createNotification($notificationData);
            $this->sendToAllAdmins($notification);
        }
    }

    /**
     * Create new product notification
     */
    public function createNewProductNotification(Product $product): void
    {
        $notificationData = [
            'type' => Notification::TYPE_ADMIN,
            'category' => Notification::CATEGORY_SYSTEM,
            'title' => 'Sản phẩm mới được thêm',
            'message' => "Sản phẩm {$product->name} đã được thêm vào hệ thống",
            'icon' => Notification::ICON_GIFT,
            'color' => Notification::COLOR_GREEN,
            'action_url' => route('admin.dashboard'),
            'action_text' => 'Xem sản phẩm',
            'data' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
            ],
        ];

        $notification = $this->createNotification($notificationData);
        $this->sendToAllAdmins($notification);
    }

    /**
     * Create notification for new review
     */
    public function createNewReviewNotification(Review $review)
    {
        $notification = Notification::create([
            'type' => 'new_review',
            'title' => 'Đánh giá mới',
            'message' => "Khách hàng {$review->user->name} đã đánh giá sản phẩm '{$review->product->name}' với {$review->rating} sao",
            'data' => [
                'review_id' => $review->id,
                'product_id' => $review->product_id,
                'product_name' => $review->product->name,
                'user_id' => $review->user_id,
                'user_name' => $review->user->name,
                'rating' => $review->rating,
                'comment' => $review->comment
            ]
        ]);

        // Send to all admin users
        $adminUsers = User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            $admin->notifications()->attach($notification->id, [
                'is_read' => false,
                'created_at' => now()
            ]);
        }
    }

    /**
     * Create notification for new user registration
     */
    public function createNewUserNotification(User $user)
    {
        $notification = Notification::create([
            'type' => 'new_user',
            'title' => 'Khách hàng mới đăng ký',
            'message' => "Khách hàng mới {$user->name} ({$user->email}) đã đăng ký tài khoản",
            'data' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'registration_date' => $user->created_at
            ]
        ]);

        // Send to all admin users
        $adminUsers = User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            $admin->notifications()->attach($notification->id, [
                'is_read' => false,
                'created_at' => now()
            ]);
        }
    }



    // ==================== HELPER METHODS ====================

    /**
     * Get auth notification data
     */
    private function getAuthNotificationData(User $user, string $type, array $data = []): ?array
    {
        switch ($type) {
            case 'registration_success':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Đăng ký thành công',
                    'message' => "Chào mừng {$user->name}! Tài khoản của bạn đã được tạo thành công.",
                    'icon' => Notification::ICON_CHECK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('dashboard'),
                    'action_text' => 'Bắt đầu mua sắm',
                    'data' => array_merge(['user_id' => $user->id], $data),
                ];

            case 'email_verified':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_SECURITY,
                    'title' => 'Email đã được xác thực',
                    'message' => "Email của bạn đã được xác thực thành công.",
                    'icon' => Notification::ICON_CHECK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('dashboard'),
                    'action_text' => 'Tiếp tục',
                    'data' => array_merge(['user_id' => $user->id], $data),
                ];

            case 'phone_verified':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_SECURITY,
                    'title' => 'Số điện thoại đã được xác thực',
                    'message' => "Số điện thoại của bạn đã được xác thực thành công.",
                    'icon' => Notification::ICON_CHECK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('dashboard'),
                    'action_text' => 'Tiếp tục',
                    'data' => array_merge(['user_id' => $user->id], $data),
                ];

            case 'login_from_new_device':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_SECURITY,
                    'title' => 'Đăng nhập từ thiết bị mới',
                    'message' => "Tài khoản của bạn vừa đăng nhập từ thiết bị mới: {$data['device']}",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_YELLOW,
                    'action_url' => route('profile.edit'),
                    'action_text' => 'Kiểm tra bảo mật',
                    'data' => array_merge(['user_id' => $user->id], $data),
                ];
        }

        return null;
    }

    /**
     * Get order notification data
     */
    private function getOrderNotificationData(Order $order, string $type): ?array
    {
        $data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'total' => $order->total,
        ];

        switch ($type) {
            case 'new':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đặt hàng thành công',
                    'message' => "Đơn hàng #{$order->order_number} của bạn đã được tạo thành công.",
                    'icon' => Notification::ICON_SHOPPING_CART,
                    'color' => Notification::COLOR_BLUE,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];

            case 'confirmed':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng đã xác nhận',
                    'message' => "Đơn hàng #{$order->order_number} đã được xác nhận và đang chuẩn bị giao.",
                    'icon' => Notification::ICON_CHECK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];

            case 'processing':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng đang được xử lý',
                    'message' => "Đơn hàng #{$order->order_number} đang được xử lý và chuẩn bị giao.",
                    'icon' => Notification::ICON_CLOCK,
                    'color' => Notification::COLOR_BLUE,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];

            case 'shipping':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng đang giao',
                    'message' => "Đơn hàng #{$order->order_number} đang được giao đến bạn.",
                    'icon' => Notification::ICON_TRUCK,
                    'color' => Notification::COLOR_PURPLE,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];

            case 'delivered':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng đã giao thành công',
                    'message' => "Đơn hàng #{$order->order_number} đã được giao thành công. Cảm ơn bạn đã mua hàng!",
                    'icon' => Notification::ICON_CHECK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];

            case 'cancelled':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng đã hủy',
                    'message' => "Đơn hàng #{$order->order_number} đã được hủy.",
                    'icon' => Notification::ICON_X,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];

            case 'payment_expired':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Hết hạn thanh toán',
                    'message' => "Đơn hàng #{$order->order_number} đã hết hạn thanh toán.",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Thanh toán ngay',
                    'data' => $data,
                ];
        }

        return null;
    }

    /**
     * Get payment notification data
     */
    private function getPaymentNotificationData(Order $order, string $type): ?array
    {
        $data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'amount' => $order->total,
        ];

        switch ($type) {
            case 'success':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Thanh toán thành công',
                    'message' => "Thanh toán cho đơn hàng #{$order->order_number} đã thành công.",
                    'icon' => Notification::ICON_CREDIT_CARD,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];

            case 'failed':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Thanh toán thất bại',
                    'message' => "Thanh toán cho đơn hàng #{$order->order_number} đã thất bại.",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Thử lại',
                    'data' => $data,
                ];

            case 'refunded':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Hoàn tiền thành công',
                    'message' => "Hoàn tiền cho đơn hàng #{$order->order_number} đã được xử lý.",
                    'icon' => Notification::ICON_CREDIT_CARD,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('orders.show', $order),
                    'action_text' => 'Xem đơn hàng',
                    'data' => $data,
                ];
        }

        return null;
    }

    /**
     * Get promotion notification data
     */
    private function getPromotionNotificationData(Promotion $promotion, string $type): ?array
    {
        $product = $promotion->product;
        $data = [
            'promotion_id' => $promotion->id,
            'product_id' => $product->id,
            'discount_percentage' => $promotion->discount_percentage,
        ];

        switch ($type) {
            case 'flash_sale':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_PROMOTION,
                    'title' => 'Flash Sale!',
                    'message' => "Sản phẩm {$product->name} đang giảm giá {$promotion->discount_percentage}%!",
                    'icon' => Notification::ICON_GIFT,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('products.show', $product),
                    'action_text' => 'Mua ngay',
                    'data' => $data,
                    'expires_at' => $promotion->end_date,
                ];

            case 'new_promotion':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_PROMOTION,
                    'title' => 'Khuyến mãi mới',
                    'message' => "Sản phẩm {$product->name} có khuyến mãi mới!",
                    'icon' => Notification::ICON_GIFT,
                    'color' => Notification::COLOR_ORANGE,
                    'action_url' => route('products.show', $product),
                    'action_text' => 'Xem chi tiết',
                    'data' => $data,
                    'expires_at' => $promotion->end_date,
                ];

            case 'voucher':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_PROMOTION,
                    'title' => 'Voucher dành riêng cho bạn',
                    'message' => "Bạn có voucher giảm giá {$promotion->discount_percentage}% cho sản phẩm {$product->name}!",
                    'icon' => Notification::ICON_GIFT,
                    'color' => Notification::COLOR_PURPLE,
                    'action_url' => route('products.show', $product),
                    'action_text' => 'Sử dụng ngay',
                    'data' => $data,
                    'expires_at' => $promotion->end_date,
                ];
        }

        return null;
    }

    /**
     * Get account notification data
     */
    private function getAccountNotificationData(User $user, string $type): ?array
    {
        switch ($type) {
            case 'profile_updated':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Cập nhật thông tin thành công',
                    'message' => "Thông tin tài khoản của bạn đã được cập nhật thành công.",
                    'icon' => Notification::ICON_CHECK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('profile.edit'),
                    'action_text' => 'Xem thông tin',
                    'data' => ['user_id' => $user->id],
                ];

            case 'password_changed':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_SECURITY,
                    'title' => 'Đổi mật khẩu thành công',
                    'message' => "Mật khẩu của bạn đã được thay đổi thành công.",
                    'icon' => Notification::ICON_SHIELD,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('profile.edit'),
                    'action_text' => 'Cài đặt bảo mật',
                    'data' => ['user_id' => $user->id],
                ];

            case 'password_reset_requested':
                return [
                    'type' => Notification::TYPE_CUSTOMER,
                    'category' => Notification::CATEGORY_SECURITY,
                    'title' => 'Yêu cầu khôi phục mật khẩu',
                    'message' => "Chúng tôi đã gửi email hướng dẫn khôi phục mật khẩu.",
                    'icon' => Notification::ICON_SHIELD,
                    'color' => Notification::COLOR_BLUE,
                    'action_url' => route('login'),
                    'action_text' => 'Đăng nhập',
                    'data' => ['user_id' => $user->id],
                ];
        }

        return null;
    }

    /**
     * Send email notifications
     */
    private function sendEmailNotifications(Notification $notification, array $userIds): void
    {
        // This would be implemented with actual email sending logic
        // For now, we'll just log it
        Log::info('Email notification would be sent', [
            'notification_id' => $notification->id,
            'user_ids' => $userIds,
        ]);
    }

    /**
     * Get admin order notification data
     */
    private function getAdminOrderNotificationData(Order $order, string $type): ?array
    {
        $data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'total' => $order->total,
            'customer_name' => $order->user->name,
        ];

        switch ($type) {
            case 'new':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng mới cần xử lý',
                    'message' => "Đơn hàng #{$order->order_number} từ khách hàng {$order->user->name} trị giá " . number_format($order->total, 0, ',', '.') . "đ",
                    'icon' => Notification::ICON_SHOPPING_CART,
                    'color' => Notification::COLOR_BLUE,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Xem chi tiết',
                    'data' => $data,
                    'is_important' => true,
                ];

            case 'payment_confirmation_needed':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Cần xác minh thanh toán',
                    'message' => "Khách hàng {$order->user->name} báo đã chuyển khoản cho đơn hàng #{$order->order_number}",
                    'icon' => Notification::ICON_CREDIT_CARD,
                    'color' => Notification::COLOR_ORANGE,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Kiểm tra',
                    'data' => $data,
                    'is_important' => true,
                ];

            case 'cancelled':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng bị hủy',
                    'message' => "Đơn hàng #{$order->order_number} từ {$order->user->name} đã bị hủy",
                    'icon' => Notification::ICON_X,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Xem chi tiết',
                    'data' => $data,
                ];

            case 'payment_expired':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Đơn hàng quá hạn thanh toán',
                    'message' => "Đơn hàng #{$order->order_number} đã quá hạn thanh toán",
                    'icon' => Notification::ICON_CLOCK,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Xử lý',
                    'data' => $data,
                    'is_important' => true,
                ];

            case 'ready_to_ship':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_ORDER,
                    'title' => 'Đơn hàng sẵn sàng giao',
                    'message' => "Đơn hàng #{$order->order_number} đã được xác nhận và sẵn sàng giao",
                    'icon' => Notification::ICON_TRUCK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Cập nhật trạng thái',
                    'data' => $data,
                ];
        }

        return null;
    }

    /**
     * Get admin payment notification data
     */
    private function getAdminPaymentNotificationData(Order $order, string $type): ?array
    {
        $data = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'total' => $order->total,
            'customer_name' => $order->user->name,
        ];

        switch ($type) {
            case 'payment_success':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Thanh toán thành công',
                    'message' => "Đơn hàng #{$order->order_number} đã được thanh toán thành công",
                    'icon' => Notification::ICON_CHECK,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Xem chi tiết',
                    'data' => $data,
                ];

            case 'refund_processed':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Hoàn tiền đã xử lý',
                    'message' => "Hoàn tiền cho đơn hàng #{$order->order_number} đã được xử lý",
                    'icon' => Notification::ICON_CREDIT_CARD,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Xem chi tiết',
                    'data' => $data,
                ];

            case 'payment_failed':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_PAYMENT,
                    'title' => 'Thanh toán thất bại',
                    'message' => "Thanh toán cho đơn hàng #{$order->order_number} đã thất bại",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('admin.orders.show', $order),
                    'action_text' => 'Kiểm tra',
                    'data' => $data,
                    'is_important' => true,
                ];
        }

        return null;
    }

    /**
     * Get inventory notification data
     */
    private function getInventoryNotificationData(Product $product, string $type): ?array
    {
        $data = [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'current_stock' => $product->stock,
        ];

        switch ($type) {
            case 'low_stock':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Sản phẩm sắp hết hàng',
                    'message' => "Sản phẩm {$product->name} chỉ còn {$product->stock} trong kho",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_ORANGE,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Cập nhật kho',
                    'data' => $data,
                    'is_important' => true,
                ];

            case 'out_of_stock':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Sản phẩm đã hết hàng',
                    'message' => "Sản phẩm {$product->name} đã hết hàng trong kho",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Nhập hàng',
                    'data' => $data,
                    'is_important' => true,
                ];
        }

        return null;
    }

    /**
     * Get security notification data
     */
    private function getSecurityNotificationData(User $user, string $type, array $data = []): ?array
    {
        $baseData = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ];

        switch ($type) {
            case 'new_user_registered':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Khách hàng mới đăng ký',
                    'message' => "Khách hàng {$user->name} ({$user->email}) vừa đăng ký tài khoản",
                    'icon' => Notification::ICON_USER,
                    'color' => Notification::COLOR_BLUE,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Xem thông tin',
                    'data' => array_merge($baseData, $data),
                ];

            case 'suspicious_login':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Đăng nhập lạ',
                    'message' => "Tài khoản {$user->email} đăng nhập từ địa chỉ IP lạ: {$data['ip_address']}",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Kiểm tra',
                    'data' => array_merge($baseData, $data),
                    'is_important' => true,
                ];

            case 'multiple_failed_login':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Nhiều lần nhập sai mật khẩu',
                    'message' => "Tài khoản {$user->email} có {$data['attempts']} lần nhập sai mật khẩu",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_RED,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Kiểm tra',
                    'data' => array_merge($baseData, $data),
                    'is_important' => true,
                ];
        }

        return null;
    }

    /**
     * Get business notification data
     */
    private function getBusinessNotificationData(string $type, array $data = []): ?array
    {
        switch ($type) {
            case 'daily_revenue_report':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Báo cáo doanh thu ngày',
                    'message' => "Doanh thu ngày hôm nay: " . number_format($data['revenue'], 0, ',', '.') . "đ",
                    'icon' => Notification::ICON_CHART,
                    'color' => Notification::COLOR_GREEN,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Xem báo cáo',
                    'data' => $data,
                ];

            case 'unusual_order_spike':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_SYSTEM,
                    'title' => 'Cảnh báo: Đơn hàng tăng bất thường',
                    'message' => "Số đơn hàng tăng {$data['percentage']}% so với trung bình",
                    'icon' => Notification::ICON_ALERT,
                    'color' => Notification::COLOR_ORANGE,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Xem báo cáo',
                    'data' => $data,
                    'is_important' => true,
                ];

            case 'promotion_reminder':
                return [
                    'type' => Notification::TYPE_ADMIN,
                    'category' => Notification::CATEGORY_PROMOTION,
                    'title' => 'Nhắc nhở: Theo dõi chiến dịch khuyến mãi',
                    'message' => "Chiến dịch '{$data['campaign_name']}' cần được theo dõi",
                    'icon' => Notification::ICON_GIFT,
                    'color' => Notification::COLOR_BLUE,
                    'action_url' => route('admin.dashboard'),
                    'action_text' => 'Xem chi tiết',
                    'data' => $data,
                ];
        }

        return null;
    }

    /**
     * Get notifications for user with pagination
     */
    public function getUserNotifications(User $user, int $perPage = 10)
    {
        return $user->roleNotifications()
                    ->paginate($perPage);
    }

    /**
     * Get unread notifications count for user
     */
    public function getUnreadCount(User $user): int
    {
        return $user->unread_notifications_count;
    }

    /**
     * Mark notification as read for user
     */
    public function markAsRead(User $user, int $notificationId): bool
    {
        return $user->markNotificationAsRead($notificationId);
    }

    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead(User $user): int
    {
        return $user->markAllNotificationsAsRead();
    }
}
