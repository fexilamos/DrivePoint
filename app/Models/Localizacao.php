<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'localizacoes';
    protected $fillable = [
        'bem_locavel_id',
        'cidade',
        'filial',
        'posicao',
    ];

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class, 'bem_locavel_id');
    }
}
