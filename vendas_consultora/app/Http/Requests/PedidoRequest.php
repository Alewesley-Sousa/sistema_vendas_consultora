<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PedidoRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $pedidoId = $this->route('pedido') ?? $this->route('id');
        return [
            /**
             * validação da tabela pedidos
             */
            'cliente_id' => 'nullable|exists:clientes,id',
            'status_id' => 'nullable|exists:status_pedido,id',
            'tipo_pagamento' => 'nullable|in:credito,debito,pix',

            /**
             * validação da tabela itens_pedido
             */
             'itens.*.pedido_id' => [
        		'required',
        		Rule::in([$pedidoId]) // garante que seja igual ao pedido atual
    		],
            'itens' => 'required|array',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.preco_unitario' => 'required|numeric|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'itens.*.produto_id.required' => 'é obrigatório selecionar um produto.',
            'itens.*.quantidade.required' => 'é obrigatório informar a quantidade.',
            'itens.*.quantidade.min' => 'A quantidade deve ser pelo menos 1.',
            'itens.*.preco_unitario.required' => 'é obrigatório informar o preço unitário.',
            'itens.*.preco_unitario.min' => 'O preço unitário deve ser um número positivo.',
            'itens.*.pedido_id.required' => 'Houve um erro inesperado nos itens
            do seu pedido.',
            'itens.*.pedido_id.in' => "O produto não faz parte do pedido.",

            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'status_id.exists' => 'O status selecionado não existe.',
            'tipo_pagamento.in' => 'O tipo de pagamento selecionado é inválido.'
        ];
    }
}
