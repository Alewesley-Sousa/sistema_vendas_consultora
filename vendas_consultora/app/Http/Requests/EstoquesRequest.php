<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstoquesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'quantidade'  => ['required', 'integer', 'min:0'],
        'produto_id'  => ['required', 'exists:produtos,id'], // Adicione esta linha
    ];
    }
}