<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Attribute;
use App\Models\ProductView;
use App\Models\ProductImage;
use App\Models\CustomerOrders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
   protected $fillable=[
        'name',
        'image',
        'price',
       'description',
       'category_id',
       'image_path',
       'quantity',
       'compare_price',
       'free_shipping_office',
       'free_shipping_home',
       'is_active',
       'low_stock_notified',

    ];

    public function scopeActive($qeary){
        return $qeary->where('is_active',true);
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


public function attributes()
{
    return $this->belongsToMany(Attribute::class);
}

public function customerOrders()
{
    return $this->hasMany(CustomerOrders::class);
}

}
