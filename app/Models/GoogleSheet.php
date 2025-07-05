<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleSheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_account_json',
        'spreadsheet_id',
        'sheet_name',
        'is_active',
    ];
}
