# 💄 Relatório de Desenvolvimento Frontend

**Projeto:** Sistema de Vendas de Cosméticos  
**Data:** 21/03/2026  
**Status:** Em Desenvolvimento  

---

## 1. Equipe Responsável
Conforme definido na documentação inicial:
- **Maicon:** Frontend (Líder da frente visual).
- **Pâmela:** Design das páginas e auxílio no Frontend.
- **Integração:** Nathan (Rotas/Backend) e Alewesley (Dados).

---

## 2. Stack Tecnológica
O projeto utiliza uma arquitetura MVC padrão do Laravel.

- **Framework Visual:** [Bootstrap 5](https://getbootstrap.com/) (CSS/JS).
- **Motor de Templates:** Laravel Blade.
- **Linguagens Base:** HTML5, CSS3, JavaScript (ES6+).
- **Gerenciamento de Pacotes:** NPM.
- **Requisições HTTP:** Axios.

---

## 3. Padrões de Projeto (Frontend)
De acordo com o arquivo `docs/padrões--de-projeto.md`, as seguintes convenções devem ser rigorosamente seguidas:

### Nomeclatura de Arquivos
- **Views (Blade):** `kebab-case` (ex: `lista-produtos.blade.php`).
- **Arquivos CSS/JS:** `kebab-case` (ex: `estilo-dashboard.css`).
- **Identificadores Visuais (IDs/Classes):** `kebab-case`.

### Estrutura MVC - View
- Responsável **apenas** pela interface visual.
- **Não deve conter regras de negócio** (cálculos complexos, validações de banco de dados).
- Deve receber dados processados pelos *Controllers*.

---

## 4. Configurações de Integração (Atual)

### Cliente HTTP (Axios)
O arquivo `resources/js/bootstrap.js` já está configurado para garantir a comunicação segura com a API do Laravel.

- **Headers Padrão:**
  - `X-Requested-With`: 'XMLHttpRequest' (Identifica chamadas AJAX).
- **Segurança CSRF:**
  - O token CSRF é capturado automaticamente da meta tag `<meta name="csrf-token">` e injetado em todas as requisições, prevenindo ataques de *Cross-Site Request Forgery*.

### Rotas e Consumo
As requisições frontend devem apontar para as rotas definidas em `routes/web.php` (para views) ou `routes/api.php` (para dados JSON), utilizando os verbos HTTP corretos (GET, POST, PUT, DELETE).

---

## 5. Próximos Passos Sugeridos

1. **Estruturação de Layouts:** Criar o layout mestre (`layouts/app.blade.php`) contendo o boilerplate do Bootstrap e os *includes* de header/footer.
2. **Componentização:** Identificar elementos repetitivos (cards de produtos, alertas, modais) e transformá-los em componentes Blade (`x-components`).
3. **Feedback Visual:** Implementar tratamento visual para os status de requisição (loadings, mensagens de erro via Toast/Alert).
4. **Validação Client-side:** Garantir que os formulários tenham validação básica em HTML5/JS antes do envio ao backend.

---
*Este relatório foi gerado automaticamente com base na análise da estrutura do projeto.*