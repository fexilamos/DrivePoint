<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BemLocavel extends Model
{
    protected $table = 'bens_locaveis';

    use HasFactory;

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
    return $this->hasMany(Reserva::class);
}



}


