<?php

namespace App\Service;

use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;

class UsuarioService
{

    public function cadastrarUsuario(Request $requisicao) {

        try {
            // validando se já existe um usuário cadastrado com o e-mail informado
            $usuarioCadastradoComEmailInformado = Usuario::where('email', '=', $requisicao->email)
                ->get()
                ->toArray();
            // var_dump($usuarioCadastradoComEmailInformado);

            if (count($usuarioCadastradoComEmailInformado) > 0) {

                return response()
                    ->json([
                        'msg' => 'Já existe um usuário cadastrado com esse e-mail, informe outro e-mail!',
                        'dados' => null
                    ], 200);
            }

            if ($requisicao->senha != $requisicao->senha_confirmacao) {

                return response()
                    ->json([
                        'msg' => 'A senha e a senha de confirmação devem ser iguais!',
                        'dados' => null
                    ]);
            }

            $usuario = new Usuario();
            $usuario->nome = $requisicao->nome;
            $usuario->email = $requisicao->email;
            $usuario->senha = md5($requisicao->senha);

            if ($usuario->save()) {

                return response()
                    ->json([
                        'msg' => 'Usuário cadastrado com sucesso!',
                        'dados' => [
                            'id' => $usuario->id,
                            'nome' => $usuario->nome,
                            'email' => $usuario->email
                        ]  
                    ], 200); 
            }

            return response()
                ->json([
                    'msg' => 'Ocorreu um erro ao tentar-se cadastrar o usuário!',
                    'dados' => null
                ], 200);
        } catch (Exception $e) {

            return response()
                ->json([
                    'msg' => 'Ocorreu um erro ao tentar-se cadastrar o usuário!',
                    'dados' => null
                ], 200);
        }

    }

    public function buscarUsuarioPeloId($idUsuario) {

        try {

            if (empty($idUsuario)) {

                return response()
                    ->json([
                        'msg' => 'Informe o id do usuário!',
                        'dados' => null
                    ], 200);
            }

            $usuario = Usuario::find($idUsuario);
            
            if (empty($usuario)) {

                return response()
                    ->json([
                        'msg' => 'Usuário não encontrado!',
                        'dados' => null
                    ], 200);
            }

            return response()
                ->json([
                    'msg' => 'Usuário encontrado com sucesso!',
                    'dados' => [
                        'id' => $usuario->id,
                        'nome' => $usuario->nome,
                        'email' => $usuario->email
                    ]
                ], 200);
        } catch (Exception $e) {

            return response()
                ->json([
                    'msg' => 'Ocorreu um erro ao tentar-se buscar os dados do usuário!',
                    'dados' => null
                ], 200);
        }

    }

    public function buscarUsuarioPeloEmailESenha(Request $requisicao) {

        try {
            $senha = md5($requisicao->senha);
            $usuario = Usuario::where('email', '=', $requisicao->email)->first();
            
            if (!$usuario) {

                return response()
                    ->json([
                        'msg' => 'E-mail ou senha inválidos!',
                        'dados' => null
                    ], 200);
            }

            if ($usuario->senha != $senha) {

                return response()
                    ->json([
                        'msg' => 'E-mail ou senha inválidos!',
                        'dados' => null
                    ], 200);
            }

            return response()
                ->json([
                    'msg' => 'Login efetivado com sucesso!',
                    'dados' => [ 'id' => $usuario->id, 'email' => $usuario->email ]
                ], 200);
        } catch (Exception $e) {

            return response()
                ->json([
                    'msg' => 'Ocorreu um erro ao tentar-se realizar o login!',
                    'dados' => null
                ], 200);
        }

    }

    public function alterarSenha(Request $requisicao) {

        try {

            if ($requisicao->nova_senha != $requisicao->nova_senha_confirmacao) {

                return response()->json([
                    'msg' => 'A nova senha e a senha de confirmação devem ser iguais!',
                    'dados' => null
                ], 200);
            }

            $usuario = Usuario::find($requisicao->id);
            
            if (!$usuario) {

                return response()->json([
                    'msg' => 'Usuário não encontrado!',
                    'dados' => null
                ], 200);
            }

            $senhaAntiga = md5($requisicao->senha_antiga);

            if ($usuario->senha != $senhaAntiga) {

                return response()->json([
                    'msg' => 'Seu perfil não está cadastrado com essa senha!',
                    'dados' => null
                ], 200);
            }

            $usuario->senha = md5($requisicao->nova_senha);

            if (!$usuario->save()) {

                return response()->json([
                    'msg' => 'Ocorreu um erro ao tentar-se alterar a senha!',
                    'dados' => null
                ], 200);
            }

            return response()->json([
                'msg' => 'Senha alterada com sucesso!',
                'dados' => [
                    'id' => $usuario->id,
                    'nome' => $usuario->nome,
                    'nova_senha' => $usuario->senha
                ]
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'msg' => 'Ocorreu um erro ao tentar-se alterar a senha!',
                'dados' => null
            ], 200);
        }

    }
}