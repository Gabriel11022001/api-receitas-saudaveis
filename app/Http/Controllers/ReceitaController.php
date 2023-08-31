<?php

namespace App\Http\Controllers;

use App\Service\ReceitaService;
use Illuminate\Http\Request;

class ReceitaController extends Controller
{
    private $receitaService;

    public function __construct(ReceitaService $receitaService) {
        $this->receitaService = $receitaService;
    }

    public function cadastrarReceita(Request $requisicao) {

        return $this->receitaService->cadastrarReceita($requisicao);
    }

    public function buscarTodasReceitas() {

        return $this->receitaService->buscarTodasReceitas();
    }

    public function buscarReceitasUsuario($idUsuario) {

        return $this->receitaService->buscarReceitasUsuario($idUsuario);
    }

    public function buscarReceitaPeloId($idReceita) {

        return $this->receitaService->buscarReceitaPeloId($idReceita);
    }
}
