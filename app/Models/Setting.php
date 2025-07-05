<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['logo','sidebar_color','header_image', 'site_name', 'content','background_opacity','opacity','language'];
    public function getHeaderImageAttribute($value)
    {
        return $value ?? 'header_images/com.jpg';
    }


}
