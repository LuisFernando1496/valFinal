<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = [
        'folio',
        'date',
        'total',
        'discount',
        'percent',
        'method',
        'cliente',
        'client_id',
        'user_cash_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function usercash()
    {
        return $this->belongsTo(UserHasCashRegister::class,'user_cash_id');
    }

    public function produs()
    {
        return $this->hasMany(QuoteCostService::class,'quote_id','id');
    }
}
