<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rifa extends Model
{
    protected $table = 'rifas';

    use HasFactory;

    protected $fillable = [
        'id_campanha',
        'numero',
        'id_comprador',
        'status',
        'pedido_id',
    ];

    public function campanha()
    {
        return $this->belongsTo(Campanha::class, 'id_campanha');
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, 'id_comprador');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
