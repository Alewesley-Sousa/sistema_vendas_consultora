<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $clienteId = $this->route('cliente');

        return [
            'nome' => 'required|string|max:100',
            
            // Validação de E-mail: Obrigatório, formato de email, único na tabela clientes
            'email' => [
                'required',
                'email',
                'max:150',
                'unique:clientes,email,' . $clienteId // Ignora o próprio cliente na edição
            ],

            'telefone' => 'nullable|string|max:20',
            'cep'      => 'nullable|string|size:8',
            
            // Validação de CPF: Obrigatório, 11 dígitos, único na tabela clientes
            'cpf' => [
                'required',
                'string',
                'size:11',
                'unique:clientes,cpf,' . $clienteId // Ignora o próprio cliente na edição
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este e-mail já está em uso por outro cliente.',
            'cpf.unique'   => 'Este CPF já está cadastrado no sistema.',
            'cpf.size'     => 'O CPF deve ter exatamente 11 números.',
            'email.required' => 'O e-mail é fundamental para o contato com o cliente.',
        ];
    }
}
