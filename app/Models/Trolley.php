<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trolley extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'inventory_id',
        'quantity',
        'percent',
        'discount',
        'subtotal',
        'total'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'inventory_id');
    }
}
