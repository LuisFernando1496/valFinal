<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'num_socio',
        'name',
        'last_name',
        'second_lastname',
        'age',
        'phone',
        'phone_emergency',
        'email',
        'certification',
        'photo',
        'sign',
        'date',
        'firma',
        'foto',
        'cer',
        'status',
        'comm',
    ];

    public function business()
    {
        return $this->hasMany(Businesses_partners::class, 'partner_id', 'id');
    }

    public function visits()
    {
        return $this->hasMany(Visits::class, 'partners_id', 'id');
    }
}
