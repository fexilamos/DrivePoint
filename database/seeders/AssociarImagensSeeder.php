<?php
// database/seeders/AssociarImagensSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BemLocavel;

class AssociarImagensSeeder extends Seeder
{
    public function run(): void
    {
        foreach (BemLocavel::all() as $bem) {
            $imagem = $bem->id . '.jpg';
            if (file_exists(public_path('images/' . $imagem))) {
                $bem->imagem = $imagem;
                $bem->save();
            }
        }
    }
}
