<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'package_id',
        'flavor_id',
        'price',
        'sale_type',
        'stock',
        'minimum_stock',
        'image',
        'status',
    ];
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function flavor()
    {
        return $this->belongsTo(Flavor::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function stockHistories()
    {
        return $this->hasMany(StockHistory::class);
    }
}