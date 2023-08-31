<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->string('nome')
                ->nullable(false)
                ->min(3)
                ->max(255);
            $table->string('email')
                ->nullable(false)
                ->unique();
            $table->string('senha')
                ->nullable(false)
                ->min(6)
                ->max(25);
        });
    }

    public function down() {
        Schema::dropIfExists('usuarios');
    }
};
