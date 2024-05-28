<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer_fTecnica extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'question_id',
        'partner_id'
    ];

    public function Ficha_Tecnica()
    {
        return $this->belongsTo(Ficha_Tecnica::class, 'id','question_id');
    }

    public function Partner()
    {
        return $this->belongsTo(Partners::class, 'id','partner_id');
    }
}
