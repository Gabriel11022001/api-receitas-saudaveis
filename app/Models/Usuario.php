<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'nome', 'email', 'senha'];

    public function receitas() {

        return $this->hasMany(Receita::class);
    }
}
