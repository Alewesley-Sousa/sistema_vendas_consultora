//token: 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

# 💄 Sistema de Vendas de Cosméticos

## 📌 Objetivo do Projeto

O Sistema de Vendas de Cosméticos é uma aplicação web desenvolvida para gerenciar o processo de vendas de uma empresa do ramo de cosméticos.  

O sistema permite o controle de usuários, clientes, produtos, estoque, pedidos, comissões e metas, garantindo organização das informações e integridade dos dados.

O projeto foi desenvolvido utilizando o framework Laravel com foco na aplicação prática de conceitos de modelagem relacional, desenvolvimento web e boas práticas de programação.

---

## 🛠 Tecnologias Utilizadas

- Laravel
- PHP 8+
- MySQL (sqlite -> para desenvolvimento)
- Blade
- HTML5
- CSS3
- Bootstrap 5
- Composer

---

## 👨‍💻 Integrantes

- Alewesley – Backend e Modelagem de Dados  
- Maicon – Frontend
- Nathan – Desenvolver rotas e auxiliar o backend
- Pâmela – Criar o designer das paginas e Auxiliar o frontend
- Henrique – Gerente: Gerenciar as demandas e organizar a equipe

---

## ▶️ Como Rodar o Projeto

Para executar o projeto localmente, é necessário ter instalado PHP 8.1 ou superior, Composer, MySQL e Node.js.

Primeiramente, clone o repositório:

```bash
git clone https://github.com/Alewesley-Sousa/sistema-vendas-consultora.git
cd sistema-vendas-cosmeticos
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```
---

## 📖 Documentação Adicional

Para mais detalhes sobre arquitetura, modelagem e regras de negócio, consulte a documentação complementar do projeto.
