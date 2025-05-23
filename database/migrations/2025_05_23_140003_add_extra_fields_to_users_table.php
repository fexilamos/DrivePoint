<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    //método executado com php artisan migrate
    public function up(): void {
        //recebe a instância da tabela
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefone')->nullable()->after('email');
            $table->string('nif')->unique();
            $table->date('data_nascimento')->nullable();
            $table->text('morada')->nullable();
        });
    }

    //método executado com php artisan migrate:rollback
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telefone', 'nif', 'data_nascimento', 'morada'
            ]);
        });
    }
};
