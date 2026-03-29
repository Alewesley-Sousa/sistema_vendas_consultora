<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Alterar para true para permitir que a requisição prossiga
        return true; 
    }

    public function rules(): array
    {
        return [
            'valor_meta' => 'required|numeric|min:1',
            // Valida se a data vem no formato YYYY-MM (ex: 2024-03)
            'data_referencia' => 'required|date_format:Y-m', 
        ];
    }

    public function messages(): array
    {
        return [
            'valor_meta.required' => 'O valor da meta é obrigatório.',
            'valor_meta.numeric' => 'O valor da meta deve ser um número.',
            'data_referencia.required' => 'O mês de referência é obrigatório.',
            'data_referencia.date_format' => 'O formato da data deve ser Ano-Mês (Ex: 2024-03).',
        ];
    }
}