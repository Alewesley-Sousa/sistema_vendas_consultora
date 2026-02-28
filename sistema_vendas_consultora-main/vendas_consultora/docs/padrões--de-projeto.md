# Padrões de Projeto - Sistema de Venda de Cosméticos
Este documento define as regras técnicas adotadas pela equipe durante o planejamento do projeto.
O objetivo é garantir organização, padronização e clareza no codigo, evitando iconsistências e facilitando manutenção

---

# Convenções de Nomeclatura

## Padrões de Escrita

### PascalCase
- Classes
- Models
- Controllers
- Services

### camelCase
- Variáveis
- Métodos
- Funções

### snake_case
- Nomes de tabela
- Nomes de colunas no banco de dados

### kebab-case
- Nomes de arquivos estáticos (views)
- Arquivos CSS
- Identificadores visuais

---

# Padrões de Arquitetura
está sendo usado o modelo mvc que o framework laravel já fornece

### Model
- Representa as entidades do banco de dados.
- Define relacionamentos.
- Não deve conter regra de negócio.

### Controller
- Recebe requisições.
- Válida dados.
- Chama a camada Service.
- Retorna repostas.

### View
- responsável pela interface visual.
- Desenvolvida com blade.
- Não deve conter regras de négocio

### Service
- Implementa regras de négocio.
- Executa calculos.
- Gerencia transações.
- Coordena multiplos models.

---

# Comentários e Documentação
## Cabeçalho de arquivo
Todo arquivo criado manualmente deve conter:
- Nome do autor
- Data de criacao
- Descrição  da finalidade
<details>
<summary>exemplo: </summary>

```php
/**
 * Autor: Alewesley
 * Data: 18/02/2026
 * Descrição: Service responsável pelo processamentos de pedidos.
 */
 ```
 </details>


## Comentários de função
Toda função ou método deve conter um bloco de comentário explicando:
- O que a função faz
- Quais parâmetros recebe
- O que retorna

<details>
<summary>exemplo: </summary>

```php
/**
 * calcula o valor total de um pedido com base nos itens informados.
 * 
 * @param array $itens Lista de produtos do pedido.
 * @return float valor total armazenado
 */
public function calcularTotal(array $itens): float 
{
    //codigo...
}
 ```
 </details>

## Padrões de commit
*A descrição deve ser clara, direta e indicar exatamente o que foi feito.

### Tipos de commits
|tipo     | Descrição |
|---------|-----------|
|[**FLEAT**] | Nova funcionalidade|
|[**FIX**] | Correção de erros |
|[**REF**] | Refatoração de código (sem alterar o comportamento) |
|[**DOC**] | Alteração ou criação de documentação |
|[**STYLE**] | Ajustes visuais ou formatação |
|[**TEST**] | Implementação ou modificação de testes |