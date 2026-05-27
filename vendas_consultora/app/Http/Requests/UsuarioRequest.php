<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

// No seu App\Http\Requests\UsuarioRequest.php
public function rules(): array
{
    $usuarioId = $this->route('usuario') ?? $this->route('id');

    return [
        'nome' => 'required|string|max:100',

        'cpf' => [
            'required',
            'string',
            'size:11',
            Rule::unique('usuarios', 'cpf')->ignore($usuarioId),
        ],

        'email' => [
            'required',
            'email',
            'max:150',
            Rule::unique('usuarios', 'email')->ignore($usuarioId),
        ],
        
        'telefone' => 'nullable|string|max:20',
        'senha' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
        'cep' => 'required|string|size:8',
        'consultora_id' => 'nullable|exists:usuarios,id',
        
        // MUDANÇA AQUI: de 'required' para 'nullable'
        'status_id' => 'nullable|exists:status_consultoras,id', 
    ];
}

    /**
     * Mensagens personalizadas de erro
     */
    public function messages(): array
    {
        return [
            'nome.required'     => 'O nome é obrigatório.',
            
            'email.required'    => 'O e-mail é obrigatório para o acesso.',
            'email.email'       => 'Insira um formato de e-mail válido.',
            'email.unique'      => 'Este e-mail já está sendo utilizado por outro usuário.',

            'cpf.required'      => 'O CPF é obrigatório.',
            'cpf.size'          => 'O CPF deve ter exatamente 11 números.',
            'cpf.unique'        => 'Este CPF já está cadastrado no sistema.',

            'senha.required'    => 'A senha é obrigatória para novos cadastros.',
            'senha.min'         => 'A senha deve ter no mínimo 8 caracteres.',
            
            'cep.required'      => 'O CEP é necessário para a logística.',
            'cep.size'          => 'O CEP deve conter exatamente 8 números.',
            
            'status_id.required' => 'O status da conta é obrigatório.',
            'status_id.exists'   => 'O status selecionado não existe no sistema.',
            
            'consultora_id.exists' => 'A consultora de referência selecionada é inválida.',
        ];
    }
}
