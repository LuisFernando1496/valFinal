<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'folio',
        'date',
        'total',
        'discount',
        'percent',
        'method',
        'client_id',
        'user_cash_id',
        'status'
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
        return $this->hasMany(SaleHasCostPrice::class,'sale_id','id');
    }

    public function services()
    {
        return $this->hasMany(SaleHasService::class,'sale_id','id');
    }

    // public function credits()
    // {
    //     return $this->hasMany(SaleHasCredit::class,'sale_id','id');
    // }
    public function credits()
    {
        return $this->belongsToMany(Credit::class,'sale_has_credits');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('id','DESC');
    }
}
