<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentHasInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipment_id',
        'inventory_id',
        'quantity',
        'subtotal',
        'discount',
        'total'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class,'id','shipment_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'id','inventory_id');
    }
}
