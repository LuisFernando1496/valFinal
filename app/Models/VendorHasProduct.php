<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorHasProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'product_id',
        'stock'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function costos()
    {
        return $this->hasMany(CostPrice::class,'vendor_product_id','id');
    }
}
