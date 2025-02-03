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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($campanha) {
            // Criar as rifas automaticamente
            $rifas = [];
            for ($i = 1; $i <= $campanha->num_cotas_disponiveis; $i++) {
                $rifas[] = [
                    'id_campanha' => $campanha->id,
                    'numero' => $i,
                    'status' => 'disponivel',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // Inserir as rifas em massa
            \App\Models\Rifa::insert($rifas);
        });
    }

    public function planosPromocao()
    {
        return $this->hasMany(CampanhaPlanoPromocao::class, 'campanha_id');
    }

    public function rifas()
    {
        return $this->hasMany(Rifa::class, 'id_campanha');
    }
}
