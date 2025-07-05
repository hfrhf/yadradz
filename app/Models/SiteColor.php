<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteColor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'primary_color',
        'title_color',
        'text_color',
        'button_color',
        'price_color',
        'footer_color',
        'navbar_color',
    ];
}
