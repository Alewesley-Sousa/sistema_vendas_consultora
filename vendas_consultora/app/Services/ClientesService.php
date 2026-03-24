<?php

namespace App\Services;

use App\Models\clientes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientesService 
{
    public function armazenar ($dados) {
        DB::beginTransaction();
        $usuario = Auth::user();
        
        try {
        
            $cliente = clientes::create([
                'nome' => $dados['nome'], 
                'email' => $dados['email'],
                'telefone' => $dados['telefone'],
                'cep' => $dados['cep'], 
                'cpf' => $dados['cpf'],
                'consultora_id' => $usuario->id
            ]);

            LogService::registrarAcao(
                'cadastrar cliente',
                'clientes',
                $cliente->id,
                "cliente {$cliente->nome} foi cadastrado com sucesso"
            );

            DB::commit();

            return [
                'status' => 'success',
                'messagem' => "cliente cadastrado com sucesso"
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'messagem' => 'falha ao cadastrar o cliente: ' . $e->getMessage()
            ];
        }
    }

    public function editar($dados, $id) {
        DB::beginTransaction();

        try {
            // 1. Localiza o cliente ou lança um erro 404 se não existir
            $cliente = clientes::findOrFail($id);

            // 2. Atualiza os dados (O Eloquent ignora campos que não mudaram)
            $cliente->update([
                'nome'     => $dados->nome,
                'email'    => $dados->email,
                'telefone' => $dados->telefone,
                'cep'      => $dados->cep,
                'cpf'      => $dados->cpf,
            ]);

            // 3. Registra a ação no seu LogService
            LogService::registrarAcao(
                'editar cliente',
                'clientes',
                $cliente->id,
                "Dados do cliente {$cliente->nome} foram atualizados."
            );

            DB::commit();

            return [
                'status' => 'success',
                'mensagem' => 'Cliente atualizado com sucesso!'
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'mensagem' => 'Falha ao atualizar o cliente: ' . $e->getMessage()
            ];
        }
    }

    public function listarTodos() {
        // Retorna os clientes da consultora logada (ou todos, se for distribuidora)
        $usuario = Auth::user();
        
        $query = clientes::query();

        return $query->orderBy('paginate', 'asc')->paginate(5);
    }

    public function excluir($id) {
        DB::beginTransaction();
        try {
            $cliente = clientes::findOrFail($id);
            $nomeRemovido = $cliente->nome;

            $cliente->delete();

            LogService::registrarAcao(
                'excluir cliente',
                'clientes',
                $id,
                "cliente {$nomeRemovido} foi removido com sucesso"
            );

            DB::commit();
            return ['status' => 'success', 'mensagem' => 'Cliente removido com sucesso'];
        } catch (Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'mensagem' => 'Erro ao excluir: ' . $e->getMessage()];
        }
    }
}