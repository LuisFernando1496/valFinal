<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasCashRegisterHasCostPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_cash_id',
        'cost_price_id',
        'service_id',
        'quantity',
        'discount',
        'percent'
    ];

    public function usercash()
    {
        return $this->belongsTo(UserHasCashRegister::class,'user_cash_id');
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
