<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'owner_name',
        'address',
        'phone',
        'status',
        'joined_at',
    ];
    protected $casts = [
        'joined_at' => 'date',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}