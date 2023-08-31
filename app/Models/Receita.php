<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'nome', 'ingredientes', 'modo_preparo', 'data_cadastro', 'usuario_id'];

    public function usuario() {

        return $this->belongsTo(Usuario::class);
    }
}
