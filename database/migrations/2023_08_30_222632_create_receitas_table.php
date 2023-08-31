<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up() {
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->string('nome')
                ->nullable(false)
                ->min(6);
            $table->string('modo_preparo')
                ->nullable(false)
                ->min(6);
            $table->string('ingredientes')
                ->nullable(false)
                ->min(6);
            $table->dateTime('data_cadastro')
                ->nullable(false);
            $table->unsignedBigInteger('usuario_id')
                ->nullable(false);
            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios');
        });
    }

    public function down() {
        Schema::dropIfExists('receitas');
    }
};
