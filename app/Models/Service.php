<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'bar_code',
        'name',
        'cost',
        'price',
        'description',
        'office_id'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
