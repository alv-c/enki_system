<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'campanha_id', 'status'];

    public function campanha()
    {
        return $this->belongsTo(Campanha::class);
    }

    public function rifas()
    {
        return $this->hasMany(Rifa::class);
    }
}
