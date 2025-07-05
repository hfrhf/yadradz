<?php

namespace App\Models;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
        'state',
        'to_office_price',
        'to_home_price',
    ];

    public function municipalities()
{
    return $this->hasMany(Municipality::class, 'state_id');
}

}
