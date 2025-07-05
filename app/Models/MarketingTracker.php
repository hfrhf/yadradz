<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingTracker extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'identifier',
        'token',
        'type',
        'is_active',

    ];
}
