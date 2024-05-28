<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'office_id',
        'subtotal',
        'percent',
        'discount',
        'total',
        'method',
        'status'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }
}
