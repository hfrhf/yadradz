<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[

       'product_id',
       'user_id',
       'method_payment',
       'total_amount',
        'order_number',
        'name_product',

    ];

 // علاقة الطلب مع المنتج
 public function product()
 {
     return $this->belongsTo(Product::class);
 }

 // علاقة الطلب مع المستخدم
 public function user()
 {
     return $this->belongsTo(User::class);
 }
}
