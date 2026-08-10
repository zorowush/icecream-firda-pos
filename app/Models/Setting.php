<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'owner_name',
        'logo',
        'address',
        'phone',
        'email',
        'minimum_stock',
        'tax',
        'receipt_footer',
    ];
}