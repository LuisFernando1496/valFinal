<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'available',
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class,'sale_has_credits');
    }
}
