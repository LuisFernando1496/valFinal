<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'bar_code',
        'name',
        'description',
        'cost',
        'price',
        'stock',
        'mark',
        'category_id',
        'warehouse_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

}
