<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'bar_code',
        'name',
        'description',
        'mark',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function vendor()
    {
        return $this->hasMany(VendorHasProduct::class,'product_id','id');
    }
}
