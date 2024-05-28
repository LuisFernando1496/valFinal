<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseHasSaleHasCostPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'expense_id',
        'sale_has_cost_price_id'
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class,'id','expense_id');
    }

    public function salecostprice()
    {
        return $this->belongsTo(SaleHasCostPrice::class,'id','sale_has_cost_price_id');
    }
}
