<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'subtotal',
        'percent',
        'discount',
        'total',
        'method'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function inventarios()
    {
        return $this->hasMany(BuyInventory::class,'buy_id','id');
    }
}
