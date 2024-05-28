<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteCostService extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'cost_price_id',
        'service_id',
        'quantity',
        'discount',
        'percent'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class,'sale_id');
    }

    public function costprice()
    {
        return $this->belongsTo(CostPrice::class,'cost_price_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
}
