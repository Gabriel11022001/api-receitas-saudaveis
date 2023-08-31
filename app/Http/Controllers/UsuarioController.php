<?php

namespace App\Http\Controllers;

use App\Service\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private $usuarioService;

    public function __construct(UsuarioService $usuarioService) {
        $this->usuarioService = $usuarioService;
    }

    public function cadastrarUsuario(Request $requisicao) {
        
        return $this->usuarioService->cadastrarUsuario($requisicao);
    }

    public function buscarUsuarioPeloId($idUsuario) {

        return $this->usuarioService->buscarUsuarioPeloId($idUsuario);
    }

    public function login(Request $requisicao) {

        return $this->usuarioService->buscarUsuarioPeloEmailESenha($requisicao);
    }

    public function alterarSenha(Request $requisicao) {

        return $this->usuarioService->alterarSenha($requisicao);
    }
}
