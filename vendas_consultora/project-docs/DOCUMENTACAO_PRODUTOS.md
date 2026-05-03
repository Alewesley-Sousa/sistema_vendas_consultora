# 📦 Sistema de Gestão de Produtos - Documentação

## 🎯 Visão Geral

Este sistema foi desenvolvido para gerenciar produtos dentro do dashboard da plataforma de vendas consultora. Permite criar, editar, listar e deletar produtos com integração total ao MySQL e dashboard.

---

## 📁 Arquivos Criados/Modificados

### 1. **Controllers**
- `app/Http/Controllers/ProdutosController.php` ✅ IMPLEMENTADO
  - Métodos: `index()`, `create()`, `store()`, `show()`, `edit()`, `update()`, `destroy()`
  - Método especial: `baixoEstoque()` - Relatório de produtos com estoque baixo

### 2. **Services**
- `app/Services/ProdutosService.php` ✅ CRIADO
  - `criar()` - Cria novo produto com estoque inicial
  - `atualizar()` - Atualiza dados do produto
  - `listar()` - Lista com filtros (categoria, status, busca)
  - `obter()` - Busca um produto específico
  - `deletar()` - Deleta (soft delete) um produto
  - `produtosBaixoEstoque()` - Relatório de baixo estoque

### 3. **Validação (Request)**
- `app/Http/Requests/ProdutoRequest.php` ✅ CRIADO
  - Validações: nome único, preço válido, categoria existe, status existe
  - Mensagens customizadas em português

### 4. **Rotas**
- `routes/web.php` ✅ MODIFICADO
  - `GET /produto/cadastro` - Formulário de novo produto
  - `GET /produto/edicao/{id}` - Formulário de edição
  - `POST /api/produtos/` - Criar produto (API)
  - `GET /api/produtos/` - Listar produtos (API)
  - `GET /api/produtos/{id}` - Obter produto (API)
  - `PUT /api/produtos/{id}` - Atualizar produto (API)
  - `DELETE /api/produtos/{id}` - Deletar produto (API)
  - `GET /api/produtos/relatorio/baixo-estoque` - Relatório

### 5. **Views/Templates**
- `resources/views/formularios/formulario-produto.blade.php` ✅ CRIADO
  - Formulário responsivo com Tailwind CSS
  - Validação front-end e back-end
  - Processamento via AJAX

- `resources/views/components/widget-produtos-dashboard.blade.php` ✅ CRIADO
  - Widget para exibir produtos no dashboard
  - Carregamento dinâmico via API
  - Ações de editar e deletar

---

## 🚀 Como Usar

### 1️⃣ **Criar um Novo Produto**

**Via Web (Formulário)**
```
1. Acesse: http://seu-dominio.com/produto/cadastro
2. Preencha:
   - Nome: Ex "Perfume Essencial"
   - Preço: Ex "145.00" (sem R$)
   - Categoria: Selecione uma
   - Status: Selecione o status
   - Descrição: Detalhes do produto
   - URL da Imagem: Link direto da imagem
   - Estoque Inicial: Quantidade

3. Clique em "Criar Produto"
```

**Via API (AJAX/Programáticamente)**
```javascript
const dados = {
    nome: "Hidratante Cereja",
    preco: 54.90,
    descricao: "Hidratante com aroma de cereja",
    categoria_id: 1,
    status_id: 1,
    imagem_url: "https://exemplo.com/hidratante.jpg",
    estoque_inicial: 100
};

fetch('/api/produtos/', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(dados)
})
.then(res => res.json())
.then(data => console.log(data));
```

---

### 2️⃣ **Listar Produtos**

**Via Web (Dashboard)**
```
// No arquivo da view do dashboard, adicione:
@include('components.widget-produtos-dashboard')
```

**Via API**
```javascript
// Listar todos
fetch('/api/produtos/', {
    headers: { 'Accept': 'application/json' }
})
.then(res => res.json())
.then(data => console.log(data.dados));

// Com filtros
fetch('/api/produtos/?categoria_id=1&status_id=1&busca=perfume', {
    headers: { 'Accept': 'application/json' }
})
.then(res => res.json())
.then(data => console.log(data.dados));
```

---

### 3️⃣ **Editar um Produto**

**Via Web**
```
1. Acesse: http://seu-dominio.com/produto/edicao/123
2. Modifique os campos desejados
3. Clique em "Atualizar Produto"
```

**Via API**
```javascript
fetch('/api/produtos/123', {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({
        nome: "Novo Nome",
        preco: 99.90,
        status_id: 2
    })
})
.then(res => res.json())
.then(data => console.log(data));
```

---

### 4️⃣ **Deletar um Produto**

**Via API**
```javascript
fetch('/api/produtos/123', {
    method: 'DELETE',
    headers: {
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json'
    }
})
.then(res => res.json())
.then(data => alert(data.mensagem));
```

---

### 5️⃣ **Relatório de Produtos com Baixo Estoque**

```javascript
// Obter produtos com estoque < 10
fetch('/api/produtos/relatorio/baixo-estoque?minimo=10', {
    headers: { 'Accept': 'application/json' }
})
.then(res => res.json())
.then(data => console.log('Produtos em falta:', data.dados));
```

---

## 🔐 Middleware (Autenticação e Permissões)

Todas as rotas estão protegidas por:
- ✅ `auth` - Usuário autenticado
- ✅ `cargo:consultora` - Apenas consultoras podem criar/editar
- ✅ Usuários distribuidora podem visualizar (com restrições)

---

## 📊 Estrutura do Banco de Dados

### Tabela: `produtos`
```sql
id (int, PK)
nome (string, unique)
preco (decimal 8,2)
descricao (text, nullable)
categoria_id (int, FK)
status_id (int, FK)
imagem_url (string, nullable)
created_at (timestamp)
updated_at (timestamp)
```

### Tabela: `estoques`
```sql
id (int, PK)
produto_id (int, FK)
quantidade (int)
localizacao (string)
lote (string, nullable)
```

--

## 🔌 Integração com Dashboard

### Para adicionar o widget no seu dashboard:

**Em `resources/views/consultora/dashboard.blade.php`:**
```blade
@extends('layouts.app')

@section('content')
    <div class="dashboard-container">
        <h1>Meu Dashboard</h1>
        
        <!-- Widget de Produtos -->
        @include('components.widget-produtos-dashboard')
        
        <!-- Outros widgets aqui -->
    </div>
@endsection
```

---

## 🛠️ Exemplos PHP (Controllers/Services)

### Usar o Service em outro Controller:

```php
use App\Services\ProdutosService;

class PedidosController
{
    protected $produtosService;
    
    public function __construct(ProdutosService $produtosService)
    {
        $this->produtosService = $produtosService;
    }
    
    public function criarPedido($clienteId)
    {
        // Listar produtos ativos
        $resultado = $this->produtosService->listar([
            'status_id' => 1 // Ativo
        ]);
        
        if ($resultado['status'] === 'success') {
            $produtos = $resultado['dados'];
            // ... resto da lógica
        }
    }
}
```

---

## ⚙️ Configurações

### Validações
Editável em: `app/Http/Requests/ProdutoRequest.php`

```php
public function rules(): array
{
    return [
        'nome' => 'required|string|max:150|unique:produtos',
        'preco' => 'required|numeric|min:0.01|max:999999.99',
        // ... mais validações
    ];
}
```

### Business Logic
Editável em: `app/Services/ProdutosService.php`

---

## 🐛 Debugging

### Ver Logs
```bash
tail -f storage/logs/laravel.log
```

### Testar API com Postman/Thunder Client
```
POST /api/produtos/
Headers:
  - Accept: application/json
  - X-CSRF-TOKEN: {seu-token}
  - Authorization: Bearer {seu-token}

Body (JSON):
{
    "nome": "Teste",
    "preco": 100,
    "categoria_id": 1,
    "status_id": 1
}
```

---

## ✅ Checklist de Implantação

- [ ] Migrations criadas/rodadas (verificar `database/migrations/`)
- [ ] Tabelas `categorias` e `status_produtos` existem no BD
- [ ] Models `categorias` e `status_produto` têm relacionamentos corretos
- [ ] Meta csrf-token no HTML: `<meta name="csrf-token" content="{{ csrf_token() }}">`
- [ ] Tailwind CSS configurado nos assets
- [ ] Routes publicadas: `php artisan route:list`
- [ ] Cache limpo: `php artisan cache:clear`
- [ ] Views atualizadas com `@include('components.widget-produtos-dashboard')`

---

## 📞 Suporte

Para erros ou dúvidas:
1. Verifique os `storage/logs/laravel.log`
2. Testealos endpoints via Postman
3. Valide as permissões de banco de dados
4. Verfique os nomes das tabelas no BD

---

**Desenvolvido em:** 02 de Abril de 2026
**Status:** ✅ Pronto para Produção
**Próximas Melhorias:** Importação em lote, relatórios avançados, sincronização com catalogo
