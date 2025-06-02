<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'marca';
    protected $fillable = ['nome', 'tipo_bem_id', 'observacao'];

    public function bensLocaveis()
    {
        return $this->hasMany(BemLocavel::class, 'marca_id');
    }
}
