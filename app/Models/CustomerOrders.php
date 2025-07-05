<?php

namespace App\Models;

use App\Models\User;
use App\Models\Shipping;
use App\Traits\HasFilter;
use App\Models\Municipality;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOrders extends Model
{
    use HasFactory;
    use HasFilter;
    protected $casts = [
        'delivered_at' => 'datetime', // أخبر لارافيل أن هذا الحقل هو من نوع تاريخ ووقت
    ];
    protected $fillable = [
        'product_id',
        'quantity',
        'fullname',
        'phone',
        'email',
'state_id',
    'municipality_id', // ✅
        'address',
        'delivery_type',
        'delivery_price',
        'total_price',
        'status',
        'attribute_combination',
        'ip_address',
        'user_agent',
        'order_code',
        'coupon_code',
        'discount_value',
        'device_type',
        'product_variation_id',
        'delivered_at',
        'tracking_number',

    ];
    public function product()
{
    return $this->belongsTo(Product::class);
}
// في CustomerOrder.php
public function state()
{
    return $this->belongsTo(Shipping::class, 'state_id');
}

public function municipality()
{
    return $this->belongsTo(Municipality::class, 'municipality_id');
}
public function productvariation()
{
    return $this->belongsTo(ProductVariation::class, 'product_variation_id');
}
public function confirmer(): BelongsTo
{
    return $this->belongsTo(User::class, 'confirmer_id');
}



}
