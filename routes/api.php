<?php

use App\Http\Controllers\ReceitaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::post('/usuario', [ UsuarioController::class, 'cadastrarUsuario' ]);
Route::get('/usuario/{id}', [ UsuarioController::class, 'buscarUsuarioPeloId' ]);
Route::post('/usuario/login', [ UsuarioController::class, 'login' ]);
Route::post('/receita', [ ReceitaController::class, 'cadastrarReceita' ]);
Route::get('/receita', [ ReceitaController::class, 'buscarTodasReceitas' ]);
Route::get('/receita/usuario/{id}', [ ReceitaController::class, 'buscarReceitasUsuario' ]);
Route::get('/receita/{id}', [ ReceitaController::class, 'buscarReceitaPeloId' ]);
Route::put('/usuario/alterar-senha', [ UsuarioController::class, 'alterarSenha' ]);
