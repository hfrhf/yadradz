<?php

namespace App\Models;

use App\Models\Shipping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'is_delivery',

    ];

    public function shipping(){
        return $this->belongsTo(Shipping::class, 'state_id');
    }
}
