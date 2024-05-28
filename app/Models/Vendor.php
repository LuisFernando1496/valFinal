<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address_id',
        'office_id'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class,'office_id');
    }
}
