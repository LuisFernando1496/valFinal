<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientHasFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'file_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class,'id','client_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class,'id','file_id');
    }
}
