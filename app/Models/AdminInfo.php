<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'facebook',
        'email',
        'twitter',
        'phone',
    ];
}
