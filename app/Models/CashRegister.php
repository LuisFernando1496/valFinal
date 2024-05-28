<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'starting_amount',
        'office_id'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
