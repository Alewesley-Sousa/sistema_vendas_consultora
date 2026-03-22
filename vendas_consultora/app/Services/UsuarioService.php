<?php

namespace App\Services;

use App\Models\usuarios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;

class UsuarioService
{
    public function listar() {
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
}
?>