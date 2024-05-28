<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorHasProductHasFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_product_id',
        'file_id'
    ];

    public function vendorproduct()
    {
        return $this->belongsTo(VendorHasProduct::class,'id','vendor_product_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class,'id','file_id');
    }
}
