<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class CreateAdminNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:create-admin {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin notifications for testing';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService)
    {
        $type = $this->argument('type');

        switch ($type) {
            case 'order-new':
                $order = Order::first();
                if ($order) {
                    $notificationService->createAdminOrderNotification($order, 'new');
                    $this->info('Created admin order notification: new order');
                } else {
                    $this->error('No orders found');
                }
                break;

            case 'order-cancelled':
                $order = Order::first();
                if ($order) {
                    $notificationService->createAdminOrderNotification($order, 'cancelled');
                    $this->info('Created admin order notification: cancelled order');
                } else {
                    $this->error('No orders found');
                }
                break;

            case 'payment-confirmation':
                $order = Order::first();
                if ($order) {
                    $notificationService->createAdminOrderNotification($order, 'payment_confirmation_needed');
                    $this->info('Created admin payment notification: confirmation needed');
                } else {
                    $this->error('No orders found');
                }
                break;

            case 'payment-success':
                $order = Order::first();
                if ($order) {
                    $notificationService->createAdminPaymentNotification($order, 'payment_success');
                    $this->info('Created admin payment notification: payment success');
                } else {
                    $this->error('No orders found');
                }
                break;

            case 'inventory-low':
                $product = Product::first();
                if ($product) {
                    $notificationService->createInventoryNotification($product, 'low_stock');
                    $this->info('Created inventory notification: low stock');
                } else {
                    $this->error('No products found');
                }
                break;

            case 'security-login':
                $user = User::first();
                if ($user) {
                    $notificationService->createSecurityNotification($user, 'suspicious_login', [
                        'ip_address' => '192.168.1.100'
                    ]);
                    $this->info('Created security notification: suspicious login');
                } else {
                    $this->error('No users found');
                }
                break;

            case 'business-revenue':
                $notificationService->createBusinessNotification('daily_revenue_report', [
                    'revenue' => 15000000
                ]);
                $this->info('Created business notification: daily revenue report');
                break;

            case 'all':
                $this->createAllNotifications($notificationService);
                break;

            default:
                $this->error('Invalid notification type. Available types: order-new, order-cancelled, payment-confirmation, payment-success, inventory-low, security-login, business-revenue, all');
                break;
        }
    }

    private function createAllNotifications(NotificationService $notificationService)
    {
        $order = Order::first();
        $product = Product::first();
        $user = User::first();

        if ($order) {
            $notificationService->createAdminOrderNotification($order, 'new');
            $notificationService->createAdminOrderNotification($order, 'cancelled');
            $notificationService->createAdminOrderNotification($order, 'payment_confirmation_needed');
            $notificationService->createAdminPaymentNotification($order, 'payment_success');
        }

        if ($product) {
            $notificationService->createInventoryNotification($product, 'low_stock');
        }

        if ($user) {
            $notificationService->createSecurityNotification($user, 'suspicious_login', [
                'ip_address' => '192.168.1.100'
            ]);
        }

        $notificationService->createBusinessNotification('daily_revenue_report', [
            'revenue' => 15000000
        ]);

        $this->info('Created all admin notifications');
    }
}
