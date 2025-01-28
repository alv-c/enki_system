<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampanhaPlanoPromocao extends Model
{
    protected $table = 'campanha_planos_promocao';
    
    use HasFactory;

    protected $fillable = [
        'id_campanha',
        'num_rifas',
        'valor_plano',
    ];

    public function campanha()
    {
        return $this->belongsTo(Campanha::class, 'campanha_id');
    }
}
