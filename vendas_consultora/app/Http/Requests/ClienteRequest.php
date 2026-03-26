<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'email' => [
                'required',
                'email',
                'max:150',
                'unique:clientes,email,' . $clienteId 
            ],
            'telefone' => 'nullable|string|max:20|min:11',
            'cep'      => 'nullable|string|size:8',
            'cpf' => [
                'required',
                'string',
                'size:11',
                'unique:clientes,cpf,' . $clienteId 
            ]
        ];
    }

    /**
     * Customiza a resposta de falha para evitar mensagens poluídas no Front-end.
     * Isso remove o sufixo "(and 1 more error)" nativo do Laravel.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => 'error',
            'messagem' => $validator->errors()->first(), // Pega apenas a primeira frase limpa
            'errors'   => $validator->errors()
        ], 422));
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este e-mail já está em uso por outro cliente.',
            'cpf.unique'   => 'Este CPF já está cadastrado no sistema.',
            'telefone.min'     => 'O telefone deve ter no minimo 11 números.',
            'cep.size'     => 'O CEP deve ter exatamente 8 números.',
            'cpf.size'     => 'O CPF deve ter exatamente 11 números.',
            'email.required' => 'O e-mail é fundamental para o contato com o cliente.',
        ];
    }
}
