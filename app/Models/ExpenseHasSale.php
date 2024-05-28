<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseHasSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'expense_id',
        'sale_id'
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class,'id','expense_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class,'id','sale_id');
    }
}
