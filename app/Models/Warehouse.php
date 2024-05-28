<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'business_id',
        'user_id',
        'status'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class,'business_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
