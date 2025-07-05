<?php

namespace App\Models;

use App\Models\Attribute;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends Model
{
    use HasFactory;
    protected $fillable = ['attribute_id', 'value'];


public function attribute()
{
    return $this->belongsTo(Attribute::class);
}
public function productVariations()
{
    return $this->belongsToMany(ProductVariation::class, 'product_variation_attribute_value');
}

}
