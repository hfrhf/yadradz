<?php

namespace App\Services;

use App\Models\CustomerOrders;
use App\Models\User;

class OrderDistributionService
{
    public static function assignOrderToNextConfirmer(CustomerOrders $order)
    {
        $nextConfirmer = User::role('confirmer')
            ->orderBy('last_assigned_at', 'asc')
            ->first();

        if ($nextConfirmer) {
            // ✨ --- التعديل هنا: نملأ الحقل الجديد --- ✨
            $order->assigned_to_user_id = $nextConfirmer->id;
            $order->save();

            $nextConfirmer->last_assigned_at = now();
            $nextConfirmer->save();
        }
    }
}