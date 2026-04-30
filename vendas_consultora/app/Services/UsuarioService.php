<?php

namespace App\Services;

use App\Models\usuarios;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;

class UsuarioService
{
    public function listar()
    {
        return usuarios::all();
    }

    public function registrarUsuario($dados)
    {
        DB::beginTransaction();
        $usuario = Auth::user();
        try {
            $usr = usuarios::create([
                'nome' => $dados->nome,
                'cargo' => $usuario->cargo === 'consultora' ? 'consultora' : $dados->cargo,
                'email' => $dados->email,
                'telefone' => $dados->telefone,
                'senha' =>  Hash::make($dados->senha),
                'cep' => $dados->cep,
                'cpf' => $dados->cpf,
                'consultora_id' => in_array($usuario->cargo, ['consultora', 'lider']) ? $usuario->id : null,
                'status_id' => $usuario->cargo === 'consultora' ? 3 : $dados->status
            ]);

            $descricao = $usuario->cargo === 'consultora' ? "consultor(a) $usuario->nome fazendo pré cadastro de $usr->nome." : "usuario(a) $usuario->nome fazendo cadastro do(a) $usr->nome";

            LogService::registrarAcao(
                'cadastrar novo usuario',
                'usuarios',
                $usr->id,
                $descricao
            );

            DB::commit();

            return [
                'status' => 'success',
                'mensagem' => "usuario " . $usr->status_id === 3 ? 'pré ' : ' ' . "cadastrado com sucesso"
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'messagem' => 'falha ao cadastrar o usuario: ' . $e->getMessage()
            ];
        }
    }

    public function atualizarRegistro($dados, $id)
    {
        DB::beginTransaction();

        try {
            $usuario = Usuarios::findOrFail($id);
            $usuario->update($dados);

            DB::commit();

            return [
                'status' => 'success',
                'mensagem' => 'usuario atualizado com sucesso!'
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'messagem' => 'falha ao atualizar o usuario: ' . $e->getMessage()
            ];
        }
    }

    public function destroy(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $usuario = Usuarios::findOrFail($id);

                // O método delete() retorna true se conseguir apagar
                return $usuario->delete();
            });
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir usuário: " . $e->getMessage());
        }
    }

    public function visualizarSolicitacoesDeNovasConsultora()
    {
        try {
            // Busca os registros
            $usuarios = usuarios::where('status_id', 3)->get();

            // O segredo está aqui: verificar se a coleção está vazia
            if ($usuarios->isEmpty()) {
                // Agora sim a Exception será lançada se não houver ninguém
                throw new \Exception('Não há nenhum pré cadastro.');
            }

            return [
                'status' => 'success',
                'dados' => $usuarios
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'problema na busca de consultoras: ' . $e->getMessage()
            ];
        }
    }

    /**
     * @var decisao só recebe dois valores: 0 (cadastro não aprovado) e 1 (cadastro aprovado)
     */
 public function aprovarOuRecusarCadastro(int $id, int $decisao)
{
    DB::beginTransaction();
    try {
        // 1. Busca o usuário primeiro
        $usuario = usuarios::where('id', $id)->firstOrFail();
        
        if ($usuario->status_id != 3) {
            throw new Exception("Algo deu errado ao consultar no sistema! Status atual: " . $usuario->status_id);
        }

        $authUser = Auth::user();
        $nomeUsuario = $usuario->nome; // Guarda o nome antes de deletar (se for o caso)

        // 2. Lógica de Decisão Simples
        if ($decisao == 1) {
            // APROVAR
            $usuario->update(['status_id' => 1]);
            $acao = 'aprovar cadastro';
            $descricao = "{$authUser->name} aprovou cadastro de {$nomeUsuario}";
        } else {
            // RECUSAR (Deletar)
            $usuario->forceDelete(); 
            $acao = 'recusar cadastro';
            $descricao = "{$authUser->name} recusou/deletou pré-cadastro de {$nomeUsuario}";
        }

        // 3. Registrar Log
        LogService::registrarAcao(
            $acao,
            'usuarios',
            $id,
            $descricao
        );

        DB::commit();

        return [
            'status' => 'success',
            'mensagem' => $decisao == 1 ? 'Cadastro aprovado com sucesso!' : 'Pré-cadastro deletado com sucesso!'
        ];

    } catch (Exception $e) {
        DB::rollBack();
        return [
            'status' => 'error',
            'mensagem' => 'Erro ao processar: ' . $e->getMessage()
        ];
    }
}
}
