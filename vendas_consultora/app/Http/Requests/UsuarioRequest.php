<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:100',
            
            'cargo' => [
                'required',
                Rule::in(['consultora', 'lider', 'distribuidora']),
            ],
            
            'email' => [
                'required',
                'email',
                'max:150',
                // Garante que o e-mail seja único, exceto para o próprio usuário na edição
                Rule::unique('usuarios', 'email')->ignore($this->usuario),
            ],
            
            'telefone' => 'nullable|string|max:20',
            
            // Senha obrigatória na criação, opcional na edição
            'senha' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            
            'cep' => 'required|string|max:10',
            
            'consultora_id' => 'nullable|exists:usuarios,id',
            
            'status_id' => 'required|exists:status_consultoras,id',
        ];
    }
}
