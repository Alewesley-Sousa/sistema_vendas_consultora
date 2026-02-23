-- =========================
-- STATUS CONSULTORAS
-- =========================
CREATE TABLE status_consultoras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_consultoras
INSERT INTO status_consultoras (nome, descricao) VALUES
('Ativa', 'Consultora com vendas válidas no més vigente'),
('Inativa', 'Consultora que não atingiu o minimo de vendas e foi desativada');

-- =========================
-- STATUS SOLICITAÇÃO SAQUE
-- =========================
CREATE TABLE status_solicitacao_saque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_solicitacao_saque
INSERT INTO status_solicitacao_saque (nome, descricao) VALUES
('Pendente', 'Solicitação de saque aguardando aprovação'),
('Aprovada', 'Solicitação de saque aprovada'),
('Rejeitada', 'Solicitação de saque rejeitada');

-- =========================
-- STATUS RESGATE
-- =========================
CREATE TABLE status_resgate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_resgate
INSERT INTO status_resgate (nome, descricao) VALUES
('Pendente', 'Resgate aguardando aprovação'),
('Aprovada', 'Resgate aprovado'),
('Cancelado', 'Resgate cancelado');

-- =========================
-- STATUS CATÁLOGO
-- =========================
CREATE TABLE status_catalogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_catalogo
INSERT INTO status_catalogo (nome, descricao) VALUES
('Ativo', 'Catálogo ativo e disponível'),
('Inativo', 'Catálogo inativo e indisponível');

-- =========================
-- STATUS ITEM CATÁLOGO
-- =========================
CREATE TABLE status_item_catalogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_item_catalogo
INSERT INTO status_item_catalogo (nome, descricao) VALUES
('Disponível', 'Item disponível para compra'),
('Indisponível', 'Item indisponível para compra');

-- =========================
-- STATUS DEVOLUÇÃO
-- =========================
CREATE TABLE status_devolucao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_devolucao
INSERT INTO status_devolucao (nome, descricao) VALUES
('Pendente', 'Devolução aguardando análise'),
('Aprovada', 'Devolução aprovada'),
('Rejeitada', 'Devolução rejeitada');

-- =========================
-- STATUS PROMOÇÃO
-- =========================
CREATE TABLE status_promocao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_promocao
INSERT INTO status_promocao (nome, descricao) VALUES
('Ativa', 'Promoção ativa'),
('Inativa', 'Promoção inativa'),
('Expirada', 'Promoção expirada');

-- =========================
-- STATUS META
-- =========================
CREATE TABLE status_meta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para status_meta
INSERT INTO status_meta (nome, descricao) VALUES
('Atingida', 'Meta foi atingida'),
('Não atingida', 'Meta não foi atingida'),
('Ativa', 'Meta está ativa');

-- =========================
-- TIPO COMISSÃO
-- =========================
CREATE TABLE tipos_comissao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    taxa DECIMAL(5,2),
    descricao TEXT
);

-- Dados iniciais para tipos_comissao
INSERT INTO tipos_comissao (nome, descricao, taxa) VALUES
('Venda Direta', 'Comissão gerada por venda direta da consultora', 0.30),
('nivel 1', 'Comissão gerada por venda da rede direta (1º nível)', 0.05),
('nivel 2', 'Comissão gerada por venda da rede da sua rede (2º nível)', 0.02),
('administrativa', 'taxa administrativa sobre cada venda', 0.02);

-- =========================
-- TIPO MOVIMENTAÇÃO COMISSÃO
-- =========================
CREATE TABLE tipo_movimentacao_comissao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para tipo_movimentacao_comissao
INSERT INTO tipo_movimentacao_comissao (nome, descricao) VALUES
('venda', 'Movimentação de comissão gerada por venda'),
('estorno', 'Movimentação de comissão gerada por estorno de venda, se a comissão ja tiver sido sacada, o valor do estorno será descontado do próximo saque'),
('saque', 'Movimentação de comissão gerada por solicitação de saque');

-- =========================
-- TIPO MOVIMENTAÇÃO ESTOQUE
-- =========================
CREATE TABLE tipo_movimentacao_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

-- Dados iniciais para tipo_movimentacao_estoque
INSERT INTO tipo_movimentacao_estoque (nome, descricao) VALUES
('Entrada', 'Movimentação de entrada de estoque'),
('Saída', 'Movimentação de saída de estoque');

-- =========================
-- TIPO CATÁLOGO
-- =========================
CREATE TABLE tipo_catalogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

INSERT INTO tipo_catalogo (nome, descricao) VALUES
('recompensas', 'Catálogo de recompensas para resgate de pontos'),
('vendas', 'Catálogo de produtos disponíveis para venda');

-- =========================
-- TIPO DEVOLUÇÃO
-- =========================
CREATE TABLE tipo_devolucao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

INSERT INTO tipo_devolucao (nome, descricao) VALUES
('parcial', 'Devolução parcial do pedido, onde apenas alguns itens são devolvidos'),
('total', 'Devolução total do pedido, onde todos os itens são devolvidos');

-- =========================
-- TIPO PROMOÇÃO
-- =========================
CREATE TABLE tipo_promocao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

INSERT INTO tipo_promocao (nome, descricao) VALUES
('desconto percentual', 'Promoção que oferece um desconto percentual sobre o preço do produto'),
('desconto fixo', 'Promoção que oferece um desconto fixo em reais sobre o preço do produto'),
('brinde', 'Promoção que oferece um brinde na compra do produto'),
('frete grátis', 'Promoção que oferece frete grátis na compra do produto');

-- =========================
-- STATUS PRODUTO
-- =========================
CREATE TABLE status_produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

INSERT INTO status_produto (nome, descricao) VALUES
('Ativo', 'Produto ativo e disponível para venda'),
('Inativo', 'Produto inativo'),
('Descontinuado', 'Produto descontinuado');

-- =========================
-- STATUS PEDIDO
-- =========================
CREATE TABLE status_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao TEXT
);

INSERT INTO status_pedido (nome, descricao) VALUES
('Aguardando Pagamento', 'Pedido aguardando confirmação de pagamento'),
('Pagamento Confirmado', 'Pagamento foi confirmado'),
('Separando Pedido', 'Pedido sendo separado no estoque'),
('Pronto para Envio', 'Pedido pronto para ser enviado'),
('Enviado', 'Pedido foi enviado'),
('Entregue', 'Pedido entregue ao cliente'),
('Cancelado', 'Pedido cancelado');

-- =========================
-- USUÁRIOS
-- =========================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cargo ENUM('Consultora', 'Líder', 'Distribuidora') NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    senha VARCHAR(255) NOT NULL,
    cep VARCHAR(10),
    consultora_id INT,
    status_id INT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (status_id) REFERENCES status_consultoras(id)
);

-- =========================
-- CATEGORIAS
-- =========================
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

-- =========================
-- PRODUTOS
-- =========================
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    preco DECIMAL(10,2),
    descricao TEXT,
    categoria_id INT NOT NULL,
    status_id INT NOT NULL,
    imagem_url VARCHAR(255),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    FOREIGN KEY (status_id) REFERENCES status_produto(id)
);

-- =========================
-- ESTOQUE
-- =========================
CREATE TABLE estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- =========================
-- MOVIMENTAÇÃO ESTOQUE
-- =========================
CREATE TABLE movimentacao_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    origem_tipo VARCHAR(50),
    origem_id INT,
    tipo_movimentacao_id INT NOT NULL,
    usuario_responsavel INT,
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (tipo_movimentacao_id) REFERENCES tipo_movimentacao_estoque(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- CLIENTES
-- =========================
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    telefone VARCHAR(20),
    cep VARCHAR(10),
    consultora_id INT NOT NULL,
    cpf VARCHAR(11) UNIQUE,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id)
);

-- =========================
-- PEDIDOS
-- =========================
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cliente_id INT NOT NULL,
    link VARCHAR(255),
    valor_total DECIMAL(10,2),
    tipo_pagamento ENUM('credito', 'debito', 'pix') NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)    
);

-- =========================
-- HISTÓRICO STATUS PEDIDO
-- =========================
CREATE TABLE historico_status_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    status_id INT NOT NULL,
    data_mudanca DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_responsavel INT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (status_id) REFERENCES status_pedido(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- ITENS PEDIDO
-- =========================
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    pedido_id INT NOT NULL,
    quantidade INT,
    subtotal DECIMAL(10,2),
    preco_unitario DECIMAL(10,2),
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

-- =========================
-- DEVOLUÇÕES
-- =========================
CREATE TABLE devolucoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    cliente_id INT NOT NULL,
    motivo VARCHAR(255),
    tipo_devolucao_id INT NOT NULL,
    status_id INT NOT NULL,
    data_decisao DATETIME,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_responsavel INT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (tipo_devolucao_id) REFERENCES tipo_devolucao(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (status_id) REFERENCES status_devolucao(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- ITENS DEVOLUÇÃO
-- =========================
CREATE TABLE itens_devolucao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_pedido_id INT NOT NULL,
    devolucao_id INT NOT NULL,
    quantidade INT,
    subtotal DECIMAL(10,2),
    FOREIGN KEY (item_pedido_id) REFERENCES itens_pedido(id),
    FOREIGN KEY (devolucao_id) REFERENCES devolucoes(id)
);

-- =========================
-- COMISSÕES
-- =========================
CREATE TABLE comissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    saldo_liquido DECIMAL(10,2),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id)
);

-- =========================
-- HISTÓRICO COMISSÕES
-- =========================
CREATE TABLE historico_comissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    pedido_id INT,
    tipo_comissao_id INT NOT NULL,
    valor DECIMAL(10,2),
    tipo_movimentacao_id INT NOT NULL,
    data_movimentacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_responsavel INT,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (tipo_comissao_id) REFERENCES tipos_comissao(id),
    FOREIGN KEY (tipo_movimentacao_id) REFERENCES tipo_movimentacao_comissao(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- SOLICITAÇÕES SAQUE
-- =========================
CREATE TABLE solicitacoes_saque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    valor_solicitado DECIMAL(10,2),
    status_id INT NOT NULL,
    data_decisao DATETIME,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (status_id) REFERENCES status_solicitacao_saque(id)
);

-- =========================
-- CATÁLOGOS
-- =========================
CREATE TABLE catalogos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo_catalogo_id INT NOT NULL,
    status_id INT NOT NULL,
    descricao TEXT,
    data_encerramento DATETIME,
    data_publicacao DATETIME,
    FOREIGN KEY (tipo_catalogo_id) REFERENCES tipo_catalogo(id),
    FOREIGN KEY (status_id) REFERENCES status_catalogo(id)
);

-- =========================
-- ITENS CATÁLOGO
-- =========================
CREATE TABLE itens_catalogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    preco DECIMAL(10,2),
    pontos_necessarios INT(11),
    status_id INT NOT NULL,
    estoque_disponivel INT,
    catalogo_id INT NOT NULL,
    produto_id INT NOT NULL,
    FOREIGN KEY (catalogo_id) REFERENCES catalogos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (status_id) REFERENCES status_item_catalogo(id)
);

-- =========================
-- RESGATES
-- =========================
CREATE TABLE resgates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_pontos INT,
    consultora_id INT NOT NULL,
    catalogo_id INT NOT NULL,
    data DATETIME,
    status_id INT NOT NULL,
    usuario_responsavel INT,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (catalogo_id) REFERENCES catalogos(id),
    FOREIGN KEY (status_id) REFERENCES status_resgate(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- ITENS RESGATE
-- =========================
CREATE TABLE itens_resgate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantidade INT,
    item_catalogo_id INT NOT NULL,
    resgate_id INT NOT NULL,
    subtotal_pontos INT,
    FOREIGN KEY (item_catalogo_id) REFERENCES itens_catalogo(id),
    FOREIGN KEY (resgate_id) REFERENCES resgates(id)
);

-- =========================
-- PROMOÇÕES
-- =========================
CREATE TABLE promocoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    desconto DECIMAL(10,2),
    descricao TEXT,
    tipo_promocao_id INT NOT NULL,
    data_inicio DATETIME,
    data_fim DATETIME,
    status_id INT NOT NULL,
    FOREIGN KEY (tipo_promocao_id) REFERENCES tipo_promocao(id),
    FOREIGN KEY (status_id) REFERENCES status_promocao(id)
);

-- =========================
-- ITENS PROMOÇÃO
-- =========================
CREATE TABLE itens_promocao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    promocao_id INT NOT NULL,
    quantidade_min INT,
    condicao_especial VARCHAR(100),
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (promocao_id) REFERENCES promocoes(id)
);

-- =========================
-- METAS
-- =========================
CREATE TABLE metas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    lider_id INT,
    valor_meta DECIMAL(10,2),
    data_referencia DATE,
    status_id INT NOT NULL,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (lider_id) REFERENCES usuarios(id),
    FOREIGN KEY (status_id) REFERENCES status_meta(id)
);

-- =========================
-- LOGS
-- =========================
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    acao VARCHAR(100),
    entidade_afetada VARCHAR(100),
    registro_afetado_id INT,
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    detalhes TEXT,
    ip_origem VARCHAR(45),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- =========================
-- Qualificação Profissional
-- =========================
CREATE TABLE qualificacao_profissional (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    data_validacao DATE,
    data_referencia DATE, --mês e ano
    total_vendas DECIMAL(10,2),
    recrutas_ativos_totais INT,
    status ENUM('promovido', 'rebaixado', 'pendente', 'mantida') NOT NULL,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id)
);

-- =========================
-- historico_cargo
-- =========================
CREATE TABLE historico_cargo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    qualificacao_profissional_id INT NOT NULL,
    cargo_anterior INT NOT NULL,
    cargo_novo INT,
    data_mudanca DATETIME DEFAULT CURRENT_TIMESTAMP,
);

