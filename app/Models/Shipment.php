<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'subtotal',
        'discount',
        'total',
        'type',
        'status',
        'user_id'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'id','warehouse_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id','user_id');
    }
}
