-- =========================
-- Usuários
-- =========================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    senha VARCHAR(255) NOT NULL,
    cep VARCHAR(10),
    consultora_id INT,
    status VARCHAR(20),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- Comissões
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
-- Clientes
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
-- Histórico de Comissões
-- =========================
CREATE TABLE historico_comissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    pedido_id INT NOT NULL,
    tipo_comissao VARCHAR(30),
    valor DECIMAL(10,2),
    tipo_movimentacao VARCHAR(30),
    data_movimentacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_responsavel INT,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- Movimentação de Estoque
-- =========================
CREATE TABLE movimentacao_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    origem_tipo VARCHAR(50),
    origem_id INT,
    tipo_movimentacao VARCHAR(30),
    usuario_responsavel INT,
    FOREIGN KEY (produto_id) REFERENCES produtos(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- Categorias
-- =========================
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

-- =========================
-- Pedidos
-- =========================
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cliente_id INT NOT NULL,
    link VARCHAR(255),
    valor_total DECIMAL(10,2),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- =========================
-- Solicitações de Saque
-- =========================
CREATE TABLE solicitacoes_saque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    valor_solicitado DECIMAL(10,2),
    status VARCHAR(20),
    data_decisao DATETIME,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id)
);

-- =========================
-- Resgates
-- =========================
CREATE TABLE resgates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_pontos INT,
    consultora_id INT NOT NULL,
    catalogo_id INT NOT NULL,
    data DATETIME,
    status VARCHAR(20),
    usuario_responsavel INT,
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (catalogo_id) REFERENCES catalogos(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- Catálogos
-- =========================
CREATE TABLE catalogos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo VARCHAR(50),
    status VARCHAR(20),
    descricao TEXT,
    data_encerramento DATETIME,
    data_publicacao DATETIME
);

-- =========================
-- Itens de Catálogo
-- =========================
CREATE TABLE itens_catalogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    preco DECIMAL(10,2),
    status VARCHAR(20),
    estoque_disponivel INT,
    catalogo_id INT NOT NULL,
    produto_id INT NOT NULL,
    FOREIGN KEY (catalogo_id) REFERENCES catalogos(id),
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- =========================
-- Itens de Resgate
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
-- Devoluções
-- =========================
CREATE TABLE devolucoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    cliente_id INT NOT NULL,
    motivo VARCHAR(255),
    tipo VARCHAR(50),
    status VARCHAR(20),
    data_decisao DATETIME,
    data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_responsavel INT,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (usuario_responsavel) REFERENCES usuarios(id)
);

-- =========================
-- Produtos
-- =========================
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    preco DECIMAL(10,2),
    descricao TEXT,
    ativo BOOLEAN DEFAULT TRUE,
    imagem_url VARCHAR(255),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- Estoque
-- =========================
CREATE TABLE estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    quantidade INT,
    modificado_em DATETIME ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- =========================
-- Itens de Promoção
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
-- Itens de Devolução
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
-- Itens de Pedido
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
-- Promoções
-- =========================
CREATE TABLE promocoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    desconto DECIMAL(10,2),
    descricao TEXT,
    tipo VARCHAR(50),
    data_inicio DATETIME,
    data_fim DATETIME,
    status VARCHAR(20)
);

-- =========================
-- Logs
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
-- Metas
-- =========================
CREATE TABLE metas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultora_id INT NOT NULL,
    lider_id INT,
    valor_meta DECIMAL(10,2),
    data_referencia DATE,
    status VARCHAR(20),
    FOREIGN KEY (consultora_id) REFERENCES usuarios(id),
    FOREIGN KEY (lider_id) REFERENCES usuarios(id)
);