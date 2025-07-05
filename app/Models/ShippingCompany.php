<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    use HasFactory;
    protected $fillable=[
        'is_active',
        'settings',
        'name',
        'slug',

    ];
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];
}
