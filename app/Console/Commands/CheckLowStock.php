<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;

class CheckLowStock extends Command
{
    protected $signature = 'stock:check-low';
    protected $description = 'Check for products with low stock and notify relevant users';

    public function handle()
{
    $lowStockThreshold = 10;

    // الخطوة 1: جلب المنتجات التي مخزونها منخفض **والتي لم يتم إرسال إشعار عنها بعد**
    $products = Product::where('quantity', '<=', $lowStockThreshold)
                       ->where('low_stock_notified', false) // <-- الشرط الجديد
                       ->get();

    if ($products->isEmpty()) {
        $this->info('No new products with low stock to notify about.');
        return;
    }

    $admins = User::permission('product_access')->get();

    foreach ($products as $product) {
        Notification::send($admins, new LowStockNotification($product));

        // الخطوة 2: تحديث العلم لمنع إرسال إشعارات متكررة
        $product->update(['low_stock_notified' => true]);
    }

    $this->info('Low stock notifications sent successfully!');
}
}
