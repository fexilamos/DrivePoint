<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::unprepared(file_get_contents(database_path('script/database.sql')));
        //OU
        //DB::connection('nome_conexao')->unprepared(file_get_contents(database_path('scripts/nome_arquivo.sql')));

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
