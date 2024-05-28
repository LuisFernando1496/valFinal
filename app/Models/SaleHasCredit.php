<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleHasCredit extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_id',
        'credit_id'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class,'id','sale_id');
    }

    public function credit()
    {
        return $this->belongsTo(Credit::class,'id','credit_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
