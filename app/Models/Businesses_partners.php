<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Businesses_partners extends Model
{
    use HasFactory;

    protected $fillable = [
        'businesses_id',
        'partners_id'
    ];

    public function Businesses()
    {
        return $this->belongsTo(Business::class);
    }

    public function Partners()
    {
        return $this->belongsTo(Partners::class);
    }
    
}
