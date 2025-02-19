<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    protected $guarded = [];
    protected $table = 'pedidos';

    use HasFactory;

    protected $fillable = ['user_id', 'campanha_id', 'status', 'valor_a_pagar', 'qrcode_url'];

    public function campanha()
    {
        return $this->belongsTo(Campanha::class);
    }

    public function rifas()
    {
        return $this->hasMany(Rifa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calcularValorTotal()
    {
        return $this->campanha->valor_cota * $this->rifas()->where('id_comprador', $this->user->id)->count();
    }
}
