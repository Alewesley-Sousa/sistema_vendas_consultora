<!-- Seção de Produtos - Widget Dashboard -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            📦 Meus Produtos
        </h2>
        <a href="{{ route('produto.cadastrar') }}" 
           class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition">
            + Novo Produto
        </a>
    </div>

    <!-- Lista de Produtos -->
    <div id="produtosContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="text-center py-8 text-gray-500">
            <p>Carregando produtos...</p>
        </div>
    </div>

    <!-- Botão Ver Todos -->
    <div class="mt-6 text-center">
        <a href="{{ route('consultora.produtos') }}" 
           class="text-blue-600 hover:text-blue-800 font-semibold">
            Ver todos os produtos →
        </a>
    </div>
</div>

<script>
    // Carrega produtos via API
    async function carregarProdutos() {
        try {
            const response = await fetch('/api/produtos', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            });

            const data = await response.json();

            if (data.status === 'success' && data.dados.length > 0) {
                renderizarProdutos(data.dados);
            } else {
                document.getElementById('produtosContainer').innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500 mb-4">Nenhum produto cadastrado ainda.</p>
                        <a href="{{ route('produto.cadastrar') }}" 
                           class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition">
                            Criar Primeiro Produto
                        </a>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Erro ao carregar produtos:', error);
            document.getElementById('produtosContainer').innerHTML = `
                <div class="col-span-full text-center py-8 text-red-500">
                    <p>Erro ao carregar produtos</p>
                </div>
            `;
        }
    }

    // Renderiza os produtos
    function renderizarProdutos(produtos) {
        const container = document.getElementById('produtosContainer');
        
        container.innerHTML = produtos.map(produto => `
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                ${produto.imagem_url ? `
                    <img src="${produto.imagem_url}" alt="${produto.nome}" 
                         class="w-full h-40 object-cover rounded-lg mb-3">
                ` : `
                    <div class="w-full h-40 bg-gray-300 rounded-lg mb-3 flex items-center justify-center">
                        <span class="text-gray-500">Sem imagem</span>
                    </div>
                `}
                
                <h3 class="font-bold text-gray-800 line-clamp-2">${produto.nome}</h3>
                
                <p class="text-sm text-gray-600 mb-2">
                    Categoria: <span class="font-semibold">${produto.categoria?.nome || 'N/A'}</span>
                </p>
                
                <div class="flex justify-between items-center mt-4">
                    <span class="text-xl font-bold text-green-600">
                        R$ ${parseFloat(produto.preco).toFixed(2).replace('.', ',')}
                    </span>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                        ${produto.status?.nome || 'Ativo'}
                    </span>
                </div>

                ${produto.descricao ? `
                    <p class="text-xs text-gray-600 mt-3 line-clamp-2">${produto.descricao}</p>
                ` : ''}

                <div class="flex gap-2 mt-4">
                    <a href="{{ route('produto.editar', '') }}/${produto.id}" 
                       class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white text-sm py-1 rounded transition">
                        ✏️ Editar
                    </a>
                    <button onclick="deletarProduto(${produto.id})" 
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm py-1 rounded transition">
                        🗑️ Deletar
                    </button>
                </div>
            </div>
        `).join('');
    }

    // Deleta um produto
    async function deletarProduto(produtoId) {
        if (!confirm('Tem certeza que deseja deletar este produto?')) {
            return;
        }

        try {
            const response = await fetch(`/api/produtos/${produtoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok) {
                alert('✅ ' + data.mensagem);
                carregarProdutos(); // Recarrega a lista
            } else {
                alert('❌ Erro: ' + data.mensagem);
            }
        } catch (error) {
            alert('❌ Erro ao deletar produto');
            console.error('Erro:', error);
        }
    }

    // Carrega produtos ao abrir a página
    document.addEventListener('DOMContentLoaded', carregarProdutos);
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
