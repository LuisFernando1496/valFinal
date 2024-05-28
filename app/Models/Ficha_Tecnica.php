<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha_Tecnica extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta',
        'category_id'
    ];

    public function Category()
    {
        return $this->belongsTo(Category_fTecnica::class, 'id','category_id');
    }
}
