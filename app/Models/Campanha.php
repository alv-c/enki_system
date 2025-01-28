<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campanha extends Model
{
    protected $table = 'campanhas';
    
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'subtitulo',
        'descricao',
        'status',
        'galeria',
        'valor_cota',
        'num_cotas_disponiveis',
        'id_cota_vencedora',
    ];

    protected $casts = [
        'galeria' => 'array',
    ];

    public function planos()
    {
        return $this->hasMany(CampanhaPlanoPromocao::class, 'campanha_id');
    }

    public function rifas()
    {
        return $this->hasMany(Rifa::class, 'id_campanha');
    }
}
