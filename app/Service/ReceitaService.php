<?php

namespace App\Service;

use App\Models\Receita;
use App\Models\Usuario;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;

class ReceitaService
{

    public function cadastrarReceita(Request $requisicao) {

        try {
            $usuarioReceita = Usuario::find($requisicao->usuario_id);

            if (!$usuarioReceita) {

                return response()
                    ->json([
                        'msg' => 'Esse usuário não está cadastrado no banco de dados!',
                        'dados' => null
                    ], 200);
            }

            $receita = new Receita();
            $receita->nome = $requisicao->nome;
            $receita->modo_preparo = $requisicao->modo_preparo;
            $receita->ingredientes = $requisicao->ingredientes;
            $dataCadastro = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $receita->data_cadastro = $dataCadastro->format('Y-m-d H:i:s');
            $receita->usuario_id = $requisicao->usuario_id;

            if (!$receita->save()) {

                return response()
                    ->json([
                        'msg' => 'Ocorreu um erro ao tentar-se cadastrar a receita!',
                        'dados' => null
                    ], 200);
            }

            return response()
                ->json([
                    'msg' => 'Receita cadastrada com sucesso!',
                    'dados' => [ 'id' => $receita->id, 'nome' => $receita->nome, 'ingredientes' => $receita->ingredientes , 'modo_preparo' => $receita->modo_preparo, 'data_cadastro' => $receita->data_cadastro ]
                ], 200);
        } catch (Exception $e) {

            return response()
                ->json([
                    'msg' => 'Ocorreu um erro ao tentar-se cadastrar a receita!' . $e->getMessage(),
                    'dados' => null
                ], 200);
        }

    }

    public function buscarTodasReceitas() {

        try {
            $receitas = Receita::all()->toArray();

            if (count($receitas) === 0) {

                return response()->json([
                    'msg' => 'Não existem receitas cadastradas no banco de dados!',
                    'dados' => []
                ], 200);
            }

            return response()->json([
                'msg' => 'Receitas encontradas com sucesso!',
                'dados' => $receitas
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'msg' => 'Ocorreu um erro ao tentar-se buscar as receitas!',
                'dados' => null
            ], 200);
        }

    }

    public function buscarReceitasUsuario($idUsuario) {

        try {

            if (empty($idUsuario)) {
                
                return response()->json([
                    'msg' => 'Informe o id do usuário!',
                    'dados' => null
                ], 200);
            }

            $usuario = Usuario::find($idUsuario);

            if (!$usuario) {

                return response()->json([
                    'msg' => 'Usuário não cadastrado!',
                    'dados' => null
                ], 200);
            }

            $receitasUsuario = $usuario->receitas()->get()->toArray();
            
            if (count($receitasUsuario) === 0) {

                return response()->json([
                    'msg' => 'O usuário não possui receitas!',
                    'dados' => []
                ], 200);
            }

            return response()->json([
                'msg' => 'O usuário possui receitas!',
                'dados' => $receitasUsuario
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'msg' => 'Ocorreu um erro ao tentar-se buscar as receitas do usuário!',
                'dados' => null
            ], 200);
        }

    }

    public function buscarReceitaPeloId($idReceita) {

        try {

            if (empty($idReceita)) {

                return response()->json([
                    'msg' => 'Informe o id da receita!',
                    'dados' => null
                ], 200);
            }

            $receita = Receita::find($idReceita);

            if (!$receita) {

                return response()->json([
                    'msg' => 'Receita não encontrada!',
                    'dados' => null
                ], 200);
            }

            return response()->json([
                'msg' => 'Receita encontrada com sucesso!',
                'dados' => [
                    'id' => $receita->id,
                    'nome' => $receita->nome,
                    'ingredientes' => $receita->ingredientes,
                    'modo_preparo' => $receita->modo_preparo,
                    'data_cadastro' => $receita->data_cadastro,
                    'usuario' => $receita->usuario()->get()->toArray()
                ]
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'msg' => 'Ocorreu um erro ao tentar-se buscar a receita pelo id!',
                'dados' => null
            ], 200);
        }

    }

    public function deletarReceita($idReceita) {

    }

    public function editarReceita(Request $requisicao) {

    }
}