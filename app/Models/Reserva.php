<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'bem_locavel_id',
        'data_inicio',
        'data_fim',
        'preco_total',
        'status',
    ];

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
