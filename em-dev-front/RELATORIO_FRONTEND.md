# 📑 Relatório Técnico: Frontend (em-dev-front)
A
**Data:** 21/03/2026  
**Projeto:** Sistema de Vendas de Cosméticos  
**Contexto:** Desenvolvimento da Interface Visual

---

## 1. Equipe e Responsabilidades
Conforme documentação oficial (`README.md`):

- **Líder Frontend:** Maicon
- **Design e Apoio:** Pâmela
- **Integração Backend:** Nathan e Alewesley

**Objetivo:** Desenvolver a interface visual utilizando Laravel Blade e Bootstrap 5, garantindo a comunicação correta com as rotas e *Services* desenvolvidos pelo backend.

---

## 2. Tecnologias Definidas

| Tecnologia | Uso no Projeto |
|------------|----------------|
| **Bootstrap 5** | Framework CSS principal para responsividade e componentes (Modais, Cards, Grid). |
| **Laravel Blade** | Motor de templates para renderização das Views. |
| **Axios** | Biblioteca para requisições HTTP assíncronas (AJAX) configurada no `bootstrap.js`. |
| **NPM** | Gerenciador de dependências frontend. |

---

## 3. Padrões de Projeto (Visual)
As seguintes regras foram extraídas de `docs/padrões--de-projeto.md` e devem ser aplicadas nesta pasta:

### 🔹 Convenções de Nomenclatura
- **Arquivos Blade:** Usar `kebab-case` (ex: `detalhe-pedido.blade.php`).
- **Arquivos CSS/JS:** Usar `kebab-case` (ex: `custom-styles.css`).
- **Classes e IDs HTML:** Usar `kebab-case` (ex: `<div id="lista-clientes">`).

### 🔹 Arquitetura da View
- A camada de View não deve conter lógica de negócios (cálculos de comissão, validações complexas).
- Deve apenas exibir dados recebidos dos *Controllers*.
- Formulários devem respeitar os verbos HTTP definidos nas rotas (GET, POST, PUT, DELETE).

---

## 4. Integração com Backend

### Autenticação e Segurança
- O frontend deve garantir o envio do token CSRF em formulários (`@csrf`) e requisições Axios.
- O arquivo `bootstrap.js` já injeta o token CSRF automaticamente nos headers (`X-CSRF-TOKEN`) com base na meta tag do layout principal.

### Consumo de Dados
- **Listagens:** O `UsuariosController` retorna JSON no método `index()`. O frontend deve consumir isso via Axios ou receber via injeção direta na View, dependendo da rota.
- **Feedback:** Implementar alertas visuais para sucesso (código 200/201) e erro (4xx/5xx).

---

## 5. Próximos Passos na Pasta
1. Validar a estrutura do layout base (`app.blade.php`).
2. Implementar as telas de listagem baseadas nos JSONs retornados pelos Controllers existentes.