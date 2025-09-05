<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Review;

class TestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test các loại thông báo mới';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $notificationService = app(NotificationService::class);

        if (!$type || $type === 'all') {
            $this->testAllNotifications();
        } elseif ($type === 'customer') {
            $this->testCustomerNotifications();
        } elseif ($type === 'admin') {
            $this->testAdminNotifications();
        } else {
            $this->error('Loại thông báo không hợp lệ. Sử dụng: all, customer, hoặc admin');
        }
    }

    /**
     * Test all notification types
     */
    public function testAllNotifications()
    {
        $this->info('Testing all notification types...');
        
        // Test customer notifications
        $this->testCustomerNotifications();
        
        // Test admin notifications
        $this->testAdminNotifications();
        
        $this->info('All notification tests completed!');
    }

    /**
     * Test customer notifications
     */
    public function testCustomerNotifications()
    {
        $this->info('Testing customer notifications...');
        
        $user = User::where('role', 'customer')->first();
        if (!$user) {
            $this->error('No customer user found!');
            return;
        }

        $notificationService = new NotificationService();

        // Test order notifications
        $order = Order::first();
        if ($order) {
            $notificationService->createOrderNotification($order, 'new');
            $this->info('✓ Order notification created');
            
            $notificationService->createOrderNotification($order, 'processing');
            $this->info('✓ Order processing notification created');
            
            $notificationService->createOrderNotification($order, 'shipped');
            $this->info('✓ Order shipped notification created');
            
            $notificationService->createOrderNotification($order, 'delivered');
            $this->info('✓ Order delivered notification created');
        }

        // Test payment notifications
        if ($order) {
            $notificationService->createPaymentNotification($order, 'success');
            $this->info('✓ Payment success notification created');
            
            $notificationService->createPaymentNotification($order, 'failed');
            $this->info('✓ Payment failed notification created');
            
            $notificationService->createPaymentNotification($order, 'cancelled');
            $this->info('✓ Payment cancelled notification created');
        }

        // Test auth notifications
        $notificationService->createAuthNotification($user, 'registration_success');
        $this->info('✓ Registration success notification created');
        
        $notificationService->createAuthNotification($user, 'login_alert');
        $this->info('✓ Login alert notification created');

        // Test account notifications
        $notificationService->createAccountNotification($user, 'profile_updated');
        $this->info('✓ Profile updated notification created');
        
        $notificationService->createAccountNotification($user, 'password_changed');
        $this->info('✓ Password changed notification created');

        // Test cart reminder
        $notificationService->createCartReminderNotification($user);
        $this->info('✓ Cart reminder notification created');

        // Test product recommendation
        $product = Product::first();
        if ($product) {
            $notificationService->createProductRecommendationNotification($user, $product, 'new');
            $this->info('✓ Product recommendation notification created');
        }
    }

    /**
     * Test admin notifications
     */
    public function testAdminNotifications()
    {
        $this->info('Testing admin notifications...');
        
        $notificationService = new NotificationService();

        // Test new user notification
        $user = User::where('role', 'customer')->first();
        if ($user) {
            $notificationService->createNewUserNotification($user);
            $this->info('✓ New user notification created');
        }

        // Test new order notification
        $order = Order::first();
        if ($order) {
            $notificationService->createOrderNotification($order, 'new');
            $this->info('✓ New order notification created');
        }

        // Test new review notification
        $review = Review::first();
        if ($review) {
            $notificationService->createNewReviewNotification($review);
            $this->info('✓ New review notification created');
        }

        // Test new product notification
        $product = Product::first();
        if ($product) {
            $notificationService->createNewProductNotification($product);
            $this->info('✓ New product notification created');
        }

        // Test customer VIP notification
        if ($user) {
            $notificationService->createCustomerVIPNotification($user);
            $this->info('✓ Customer VIP notification created');
        }

        // Test support request notification
        $notificationService->createSupportRequestNotification($user ?? User::first(), 'general');
        $this->info('✓ Support request notification created');

        // Test order processing delay notification
        if ($order) {
            $notificationService->createOrderProcessingDelayNotification($order);
            $this->info('✓ Order processing delay notification created');
        }

        // Test promotion expiry notification
        $promotion = Promotion::first();
        if ($promotion) {
            $notificationService->createPromotionExpiryNotification($promotion);
            $this->info('✓ Promotion expiry notification created');
        }
    }
}
