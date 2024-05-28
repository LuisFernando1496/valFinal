<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cost',
        'price',
        'vendor_product_id'
    ];

    public function vendorproduct()
    {
        return $this->belongsTo(VendorHasProduct::class,'vendor_product_id');
    }
}
