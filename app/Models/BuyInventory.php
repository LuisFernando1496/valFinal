<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'buy_id',
        'inventory_id',
        'quantity',
        'subtotal',
        'percent',
        'discount',
        'total',
        'date'
    ];

    public function buy()
    {
        return $this->belongsTo(Buy::class,'buy_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'inventory_id');
    }
}
