<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'user_id',
        'partner_id',
        'sale_type',
        'subtotal',
        'discount',
        'grand_total',
        'paid_amount',
        'change_amount',
        'payment_method',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}