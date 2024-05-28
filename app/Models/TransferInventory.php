<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferInventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'transfer_id',
        'inventory_id',
        'quantity',
        'subtotal',
        'percent',
        'discount',
        'total',
        'date'
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class,'transfer_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'inventory_id');
    }
}
