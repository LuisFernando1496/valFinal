<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'remaining',
        'sale_id',
        'client_id'
    ];

    public function salecredit()
    {
        return $this->belongsTo(SaleHasCredit::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sale::class,'sale_id','id');
    }

    public function clients()
    {
        return $this->belongsTo(Client::class,'client_id','id');
    }
}
