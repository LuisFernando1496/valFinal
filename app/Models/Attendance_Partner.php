<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance_Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'num_socio',
        'name',
        'lastname',
        'second_lastname'
    ];
}
