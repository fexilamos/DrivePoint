<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BemLocavel extends Model
{
    protected $table = 'bens_locaveis';

    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'marca_id',
        'modelo',
        'registo_unico_publico',
        'cor',
        'numero_passageiros',
        'combustivel',
        'numero_portas',
        'transmissao',
        'ano',
        'manutencao',
        'preco_diario',
        'observacao',
        'imagem',
    ];


public function reservas()
{
    return $this->hasMany(Reserva::class, 'bem_locavel_id');
}


public function estaDisponivel($data_inicio, $data_fim)
{
    return !$this->reservas()
        ->where(function ($query) use ($data_inicio, $data_fim) {
            $query->whereBetween('data_inicio', [$data_inicio, $data_fim])
                  ->orWhereBetween('data_fim', [$data_inicio, $data_fim])
                  ->orWhere(function ($query) use ($data_inicio, $data_fim) {
                      $query->where('data_inicio', '<=', $data_inicio)
                            ->where('data_fim', '>=', $data_fim);
                  });
        })
        ->exists();
}


public function marca()
{
    return $this->belongsTo(\App\Models\Marca::class, 'marca_id');
}


public function localizacoes()
{
    return $this->hasMany(\App\Models\Localizacao::class, 'bem_locavel_id');
}


}


