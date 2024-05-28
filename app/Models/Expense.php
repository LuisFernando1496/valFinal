<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'total',
        'date',
        'status',
        'category_of_expense_id',
        'user_id',
        'user_empleado_id',
        'owner_id',
        'office_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function categoryOfExpense()
    {
        return $this->belongsTo(CategoryOfExpense::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function userEmpleado()
    {
        return $this->belongsTo(User::class,'user_empleado_id');
    }
}
