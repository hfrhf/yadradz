<?php

namespace App\Models;

use App\Models\Product;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariation extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'quantity',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues() {
        return $this->belongsToMany(AttributeValue::class, 'product_variation_attribute_value');
    }
    

}
