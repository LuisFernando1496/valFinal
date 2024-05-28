<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasCashRegister extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cash_register_id',
        'amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function cashregister()
    {
        return $this->belongsTo(CashRegister::class,'cash_register_id');
    }
}
