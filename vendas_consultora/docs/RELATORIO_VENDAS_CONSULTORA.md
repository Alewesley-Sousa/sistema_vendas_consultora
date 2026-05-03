# Relatório: Views em `resources/views/vendas_e_consultora-front`

**Data:** 02/04/2026
**Escopo:** Resumo das "abas" (views) encontradas na pasta `resources/views/vendas_e_consultora-front` e recomendações práticas.

---

## 1) Arquivos analisados
- `admin.blade.php` — Layout e componentes para painel administrativo (cards, tabelas, modais).
- `app.blade.php` — Layout base com `@yield('title')`, `@stack('styles')` e `@stack('scripts')`.
- `cadastro-consultora.blade.php` — Formulário de cadastro de consultora com validações front-end e salvamento em `localStorage`.
- `cadastro-consutora.blade.php` — Versão alternativa/duplicada do cadastro (conteúdo similar).
- `catalogo-vendas.blade.php` — Grid de produtos (exemplos estáticos via `@php` / `@foreach`).
- `clientes.blade.php` — Tela de listagem de clientes (renderiza cards a partir de `localStorage`), busca cliente.
- `criar-pedido-do-cliente.html` — Arquivo presente porém vazio.
- `dashboard.blade.php` / `dashbord.php` — Dashboard com ações rápidas e navegação para as principais views.
- `estilo.css`, `java.js` — Assets referenciados por algumas views.
- `login.blade.php` / `login.php` — Formulários de autenticação (versões Blade e PHP nativo).
- `pedidos-clientes.blade.php` — Tela para selecionar produtos, calcular subtotal/total e finalizar pedido (usa `@forelse` para produtos).
- `register.blade.php` — Formulário de registro com opções de papel (cliente/funcionário/admin).
- `relatorios.blade.php` — KPIs e gráficos (Chart.js) com dados estáticos de exemplo.
- `RELATORIO_FRONTEND.md` — Documento existente com informações de frontend (já presente).
- `web.php` (local) — Rotas simples apontando para as views acima (ex.: `/clientes`, `/cadastro-consultora`, `/relatorios`, `/pedidos-clientes`).

---

## 2) Observações principais (por view)
- `app.blade.php`:
  - Layout base bem definido; permite empilhar estilos e scripts.
- `dashboard` (`dashboard.blade.php` e `dashbord.php`):
  - Oferece navegação direta para as principais funcionalidades.
  - Há duplicidade de arquivos (`dashbord.php` vs `dashboard.blade.php`) — padronizar.
- `cadastro-consultora` / `cadastro-consutora`:
  - Formulários completos, máscaras e lógica de submissão client-side.
  - Salvamento atual em `localStorage` (mock). Deve ser substituído por envio ao backend.
  - Há uma duplicata com nome errado (`cadastro-consutora`) — corrigir nomenclatura.
- `clientes`:
  - Renderização via JS de dados em `localStorage`.
  - Busca implementada client-side.
- `criar-pedido-do-cliente.html`:
  - Arquivo vazio — precisa implementar ou remover.
- `pedidos-clientes.blade.php`:
  - Lógica de cálculo de total/subtotal client-side pronta; recebe `$produtos` via rota quando necessário.
- `catalogo-vendas`:
  - Mock de catálogo via array PHP embutido; OK para protótipo.
- `relatorios`:
  - KPIs e gráfico com Chart.js usando dados estáticos — bom protótipo visual.
- `login` / `register`:
  - Formulários prontos; `@csrf` presente em blades, atenção nas versões PHP nativas.

---

## 3) Problemas detectados / pontos de atenção
- Duplicidade de arquivos (.php vs .blade.php e variações de nomes) — causa confusão e riscos de inconsistência de conteúdo.
- Uso extensivo de `localStorage` para persistência (cadastros, clientes, pedidos). Isso é apenas um mock; precisa substituir por APIs.
- Arquivo vazio (`criar-pedido-do-cliente.html`) e possíveis arquivos teste (ex.: `dashbord.php`) precisam ser analisados e removidos ou convertidos.
- Algumas rotas no `web.php` usam views com prefixo `em-dev-front` — confirmar padronização de nomes e namespaces.
- Alguns formulários usam `action='#'` ou `window.location.href='dashbord.html'` (hardcoded) — ajustar para rotas Laravel via `route()`/`url()`.

---

## 4) Recomendações e próximos passos práticos
1. Padronizar e limpar a pasta:
   - Remover duplicatas (`cadastro-consutora`, `dashbord.php`, `login.php`) ou consolidar conteúdo nos arquivos Blade oficiais.
   - Apagar ou implementar `criar-pedido-do-cliente.html`.
2. Substituir `localStorage` por integração com Controllers/API:
   - Criar endpoints REST (ex.: `POST /api/consultoras`, `GET /api/clientes`, `POST /api/pedidos`).
   - Atualizar JS para usar `fetch`/`axios` com tratamento de erros e feedback UX.
3. Ajustes nas views:
   - Usar `route('nome.da.rota')` e `url()` sempre que possível; evitar links estáticos.
   - Garantir presença de `@csrf` em todos os formulários Blade.
4. Assets e build:
   - Mover CSS/JS locais para `public/css` e `public/js` e referenciar via `mix`/`asset` ou Vite (conforme setup do projeto).
5. Testes básicos:
   - Validar fluxo de cadastro -> listagem (end-to-end) usando dados reais do backend (ou mock server).
6. Priorizar correções de UX/ACESSIBILIDADE:
   - Labels vinculados a inputs, mensagens de erro legíveis, foco no teclado.

---

## 5) Entregáveis sugeridos (curto prazo)
- Corrigir nomes e remover arquivos duplicados (2 horas).
- Implementar endpoint mínimo para `consultoras` e alterar `cadastro-consultora` para `POST` real (4–6 horas).
- Implementar `criar-pedido-do-cliente` ou remover o placeholder (1–2 horas).

---

Se desejar, eu posso: 1) aplicar a limpeza/rename dos arquivos duplicados; 2) implementar a primeira API básica (Controller + rota + exemplo de consumo JS); ou 3) transformar o mock `localStorage` do cadastro em um `POST` real para uma rota de exemplo. Qual opção prefere que eu execute agora?
