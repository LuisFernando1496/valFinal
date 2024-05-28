<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'partners_id',
        'entrada',
        'salida',
        'user_id'
    ];

    public function partners()
    {
        return $this->belongsTo('App\Models\Partners');
    }

}
