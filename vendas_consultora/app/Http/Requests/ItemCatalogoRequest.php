namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCatalogoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPost = $this->isMethod('post');

        return [
            // No POST é obrigatório, no PUT é opcional (às vezes já vem na URL)
            'catalogo_id'        => [$isPost ? 'required' : 'sometimes', 'exists:catalogos,id'],
            'produto_id'         => [$isPost ? 'required' : 'sometimes', 'exists:produtos,id'],
            'status_id'          => [$isPost ? 'required' : 'sometimes', 'exists:status_item_catalogo,id'],
            
            'preco'              => 'nullable|numeric|min:0',
            'pontos_necessarios' => 'nullable|integer|min:0',
            'estoque_disponivel' => 'integer|min:0',
        ];
    }
}
