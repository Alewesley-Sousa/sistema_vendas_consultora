-- =========================
-- USUÁRIOS
-- =========================

INSERT INTO usuarios (nome, cargo, email, telefone, senha, cep, consultora_id, status_id)
VALUES
-- Única distribuidora
('Maria Silva', 'distribuidora', 'maria.silva@example.com', '85999990001', 'senha123', '60000-000', NULL, 1),

-- Consultoras (15 registros)
('João Pereira', 'consultora', 'joao.pereira@example.com', '85999990002', 'senha123', '60000-001', null, 1),
('Ana Costa', 'consultora', 'ana.costa@example.com', '85999990003', 'senha123', '60000-002', null, 2),
('Carlos Souza', 'consultora', 'carlos.souza@example.com', '85999990004', 'senha123', '60000-003', null, 1),
('Fernanda Lima', 'consultora', 'fernanda.lima@example.com', '85999990005', 'senha123', '60000-004', null, 2),
('Lucas Martins', 'consultora', 'lucas.martins@example.com', '85999990006', 'senha123', '60000-005', null, 1),
('Patrícia Gomes', 'consultora', 'patricia.gomes@example.com', '85999990007', 'senha123', '60000-006', null, 2),
('Ricardo Nunes', 'consultora', 'ricardo.nunes@example.com', '85999990008', 'senha123', '60000-007', null, 1),
('Beatriz Melo', 'consultora', 'beatriz.melo@example.com', '85999990009', 'senha123', '60000-008', null, 2),
('Felipe Araújo', 'consultora', 'felipe.araujo@example.com', '85999990010', 'senha123', '60000-009', null, 1),
('Larissa Monteiro', 'consultora', 'larissa.monteiro@example.com', '85999990011', 'senha123', '60000-010', null, 2),
('Daniel Ribeiro', 'consultora', 'daniel.ribeiro@example.com', '85999990012', 'senha123', '60000-011', null, 1),
('Sofia Mendes', 'consultora', 'sofia.mendes@example.com', '85999990013', 'senha123', '60000-012', null, 2),
('Gabriel Fernandes', 'consultora', 'gabriel.fernandes@example.com', '85999990014', 'senha123', '60000-013', null, 1),
('Isabela Castro', 'consultora', 'isabela.castro@example.com', '85999990015', 'senha123', '60000-014', null, 2),
('Thiago Moreira', 'consultora', 'thiago.moreira@example.com', '85999990016', 'senha123', '60000-015', null, 1),

-- Líderes (4 registros)
('Paulo Henrique', 'lider', 'paulo.henrique@example.com', '85999990017', 'senha123', '60000-016', null, 1),
('Juliana Alves', 'lider', 'juliana.alves@example.com', '85999990018', 'senha123', '60000-017', null, 2),
('Roberto Dias', 'lider', 'roberto.dias@example.com', '85999990019', 'senha123', '60000-018', null, 1),
('Camila Rocha', 'lider', 'camila.rocha@example.com', '85999990020', 'senha123', '60000-019', null, 2);

-- =========================
-- CATEGORIAS
-- =========================
INSERT INTO categorias (nome, descricao)
VALUES
('Maquiagem', 'Produtos de beleza como batons, bases, sombras e delineadores.'),
('Cuidados com a Pele', 'Cremes hidratantes, protetores solares, séruns e máscaras faciais.'),
('Perfumes', 'Fragrâncias femininas, masculinas e unissex.'),
('Cabelos', 'Shampoos, condicionadores, máscaras capilares e óleos nutritivos.'),
('Unhas', 'Esmaltes, removedores, fortalecedores e acessórios para manicure.'),
('Corpo e Banho', 'Sabonetes, óleos corporais, hidratantes e esfoliantes.'),
('Anti-idade', 'Produtos específicos para redução de linhas de expressão e rejuvenescimento.'),
('Maquiagem Profissional', 'Produtos de alta performance para uso profissional em salões e eventos.'),
('Cosméticos Naturais', 'Produtos feitos com ingredientes orgânicos e sustentáveis.'),
('Kits e Presentes', 'Conjuntos de cosméticos para presente, embalagens especiais e edições limitadas.');


-- =========================
-- PRODUTOS
-- =========================
INSERT INTO produtos (nome, preco, descricao, categoria_id, status_id, imagem_url)
VALUES
('Batom Matte Vermelho', 39.90, 'Batom de longa duração com acabamento matte.', 1, 1, 'imagens/batom_matte_vermelho.jpg'),
('Base Líquida Bege Médio', 59.90, 'Base líquida com cobertura média e efeito natural.', 1, 1, 'imagens/base_liquida_bege.jpg'),
('Paleta de Sombras Neutras', 89.90, 'Paleta com 12 cores neutras para maquiagem diária.', 1, 2, 'imagens/paleta_sombras_neutras.jpg'),

('Hidratante Facial Nutritivo', 79.90, 'Creme hidratante para uso diário, rico em vitaminas.', 2, 1, 'imagens/hidratante_facial.jpg'),
('Protetor Solar FPS 50', 69.90, 'Protetor solar facial com alta proteção UVA/UVB.', 2, 1, 'imagens/protetor_solar.jpg'),
('Máscara Facial de Argila', 45.90, 'Máscara purificante com argila verde.', 2, 3, 'imagens/mascara_argila.jpg'),

('Perfume Floral Feminino', 129.90, 'Fragrância suave com notas florais.', 3, 1, 'imagens/perfume_floral.jpg'),
('Perfume Amadeirado Masculino', 139.90, 'Fragrância intensa com notas amadeiradas.', 3, 2, 'imagens/perfume_amadeirado.jpg'),

('Shampoo Revitalizante', 34.90, 'Shampoo para cabelos danificados com extratos naturais.', 4, 1, 'imagens/shampoo_revitalizante.jpg'),
('Condicionador Hidratante', 36.90, 'Condicionador para cabelos secos e quebradiços.', 4, 1, 'imagens/condicionador_hidratante.jpg'),
('Óleo Capilar Nutritivo', 49.90, 'Óleo nutritivo para pontas ressecadas.', 4, 3, 'imagens/oleo_capilar.jpg'),

('Esmalte Vermelho Clássico', 12.90, 'Esmalte de alta cobertura e brilho intenso.', 5, 1, 'imagens/esmalte_vermelho.jpg'),
('Fortalecedor de Unhas', 19.90, 'Tratamento para unhas fracas e quebradiças.', 5, 2, 'imagens/fortalecedor_unhas.jpg'),

('Sabonete Líquido Corporal', 24.90, 'Sabonete líquido suave para uso diário.', 6, 1, 'imagens/sabonete_liquido.jpg'),
('Esfoliante Corporal', 39.90, 'Esfoliante com partículas naturais para renovação da pele.', 6, 2, 'imagens/esfoliante_corporal.jpg'),

('Creme Anti-idade Noturno', 99.90, 'Creme noturno para redução de linhas de expressão.', 7, 1, 'imagens/creme_antiidade.jpg'),
('Sérum Rejuvenescedor', 119.90, 'Sérum concentrado para firmeza da pele.', 7, 3, 'imagens/serum_rejuvenescedor.jpg'),

('Kit Maquiagem Profissional', 199.90, 'Kit completo com pincéis e paleta profissional.', 8, 1, 'imagens/kit_maquiagem_profissional.jpg'),

('Hidratante Orgânico', 59.90, 'Hidratante corporal feito com ingredientes naturais.', 9, 1, 'imagens/hidratante_organico.jpg'),

('Kit Presente Cosméticos', 149.90, 'Kit especial com fragrância, hidratante e sabonete.', 10, 1, 'imagens/kit_presente.jpg');

-- =========================
-- ESTOQUE
-- =========================
INSERT INTO estoque (produto_id, quantidade)
VALUES
(1, 100),
(2, 80),
(3, 50),
(4, 120),
(5, 90),
(6, 40),
(7, 60),
(8, 30),
(9, 150),
(10, 140),
(11, 70),
(12, 200),
(13, 110),
(14, 130),
(15, 60),
(16, 45),
(17, 25),
(18, 75),
(19, 95),
(20, 55);

-- =========================
-- MOVIMENTAÇÃO ESTOQUE
-- =========================


-- =========================
-- CLIENTES
-- =========================
INSERT INTO clientes (nome, email, telefone, cep, consultora_id, cpf)
VALUES
('Carla Menezes', 'carla.menezes@example.com', '85988880001', '60010-001', 2, '11111111111'),
('Diego Santos', 'diego.santos@example.com', '85988880002', '60010-002', 3, '22222222222'),
('Mariana Oliveira', 'mariana.oliveira@example.com', '85988880003', '60010-003', 4, '33333333333'),
('Felipe Costa', 'felipe.costa@example.com', '85988880004', '60010-004', 5, '44444444444'),
('Renata Lima', 'renata.lima@example.com', '85988880005', '60010-005', 6, '55555555555'),
('Thiago Rocha', 'thiago.rocha@example.com', '85988880006', '60010-006', 7, '66666666666'),
('Luciana Alves', 'luciana.alves@example.com', '85988880007', '60010-007', 8, '77777777777'),
('Gabriel Nunes', 'gabriel.nunes@example.com', '85988880008', '60010-008', 9, '88888888888'),
('Patrícia Gomes', 'patricia.gomes@example.com', '85988880009', '60010-009', 10, '99999999999'),
('André Barbosa', 'andre.barbosa@example.com', '85988880010', '60010-010', 11, '10101010101'),
('Sofia Mendes', 'sofia.mendes@example.com', '85988880011', '60010-011', 12, '12121212121'),
('Rafael Torres', 'rafael.torres@example.com', '85988880012', '60010-012', 2, '13131313131'),
('Isabela Castro', 'isabela.castro@example.com', '85988880013', '60010-013', 3, '14141414141'),
('João Victor', 'joao.victor@example.com', '85988880014', '60010-014', 4, '15151515151'),
('Larissa Monteiro', 'larissa.monteiro@example.com', '85988880015', '60010-015', 5, '16161616161');

-- =========================
-- PEDIDOS
-- =========================
INSERT INTO pedidos (usuario_id, cliente_id, link, valor_total, tipo_pagamento)
VALUES
(2, 1, 'https://loja.com/pedido/1001', 199.90, 'credito'),
(3, 2, 'https://loja.com/pedido/1002', 89.90, 'pix'),
(4, 3, 'https://loja.com/pedido/1003', 59.90, 'debito'),
(5, 4, 'https://loja.com/pedido/1004', 149.90, 'credito'),
(6, 5, 'https://loja.com/pedido/1005', 79.90, 'pix'),
(7, 6, 'https://loja.com/pedido/1006', 129.90, 'debito'),
(8, 7, 'https://loja.com/pedido/1007', 39.90, 'credito'),
(9, 8, 'https://loja.com/pedido/1008', 249.90, 'pix'),
(10, 9, 'https://loja.com/pedido/1009', 99.90, 'debito'),
(11, 10, 'https://loja.com/pedido/1010', 59.90, 'credito'),
(12, 11, 'https://loja.com/pedido/1011', 179.90, 'pix'),
(13, 12, 'https://loja.com/pedido/1012', 119.90, 'debito'),
(14, 13, 'https://loja.com/pedido/1013', 89.90, 'credito'),
(15, 1, 'https://loja.com/pedido/1014', 139.90, 'pix'),
(16, 2, 'https://loja.com/pedido/1015', 49.90, 'debito'),
(2, 3, 'https://loja.com/pedido/1016', 229.90, 'credito'),
(3, 4, 'https://loja.com/pedido/1017', 109.90, 'pix'),
(4, 5, 'https://loja.com/pedido/1018', 69.90, 'debito'),
(5, 6, 'https://loja.com/pedido/1019', 199.90, 'credito'),
(6, 7, 'https://loja.com/pedido/1020', 159.90, 'pix');


-- =========================
-- HISTÓRICO STATUS PEDIDO
-- =========================
INSERT INTO historico_status_pedido (pedido_id, status_id, usuario_responsavel)
VALUES
(1, 1, 1), -- aguardando pagamento
(1, 2, 1), -- pagamento confirmado
(1, 3, 1), -- separando pedido
(2, 1, 1),
(2, 7, 1), -- cancelado
(3, 1, 1),
(3, 2, 1),
(3, 4, 1), -- pronto para envio
(4, 1, 1),
(4, 2, 1),
(4, 3, 1),
(4, 5, 1), -- enviado
(5, 1, 1),
(5, 2, 1),
(5, 6, 1), -- entregue
(6, 1, 1),
(6, 2, 1),
(6, 3, 1),
(6, 4, 1),
(6, 5, 1),
(7, 1, 1),
(7, 2, 1),
(7, 7, 1), -- cancelado
(8, 1, 1),
(8, 2, 1),
(8, 3, 1),
(9, 1, 1),
(9, 2, 1),
(9, 4, 1),
(9, 6, 1);

-- =========================
-- ITENS PEDIDO
-- =========================
INSERT INTO itens_pedido (produto_id, pedido_id, quantidade, preco_unitario, subtotal)
VALUES
-- Pedido 1
(1, 1, 2, 39.90, 79.80),
(2, 1, 1, 59.90, 59.90),

-- Pedido 2
(3, 2, 1, 89.90, 89.90),

-- Pedido 3
(4, 3, 1, 79.90, 79.90),
(5, 3, 2, 69.90, 139.80),

-- Pedido 4
(6, 4, 1, 45.90, 45.90),
(7, 4, 1, 129.90, 129.90),

-- Pedido 5
(8, 5, 1, 139.90, 139.90),

-- Pedido 6
(9, 6, 2, 34.90, 69.80),
(10, 6, 1, 36.90, 36.90),

-- Pedido 7
(11, 7, 1, 49.90, 49.90),

-- Pedido 8
(12, 8, 3, 12.90, 38.70),
(13, 8, 1, 19.90, 19.90),

-- Pedido 9
(14, 9, 2, 24.90, 49.80),

-- Pedido 10
(15, 10, 1, 39.90, 39.90),
(16, 10, 1, 99.90, 99.90),

-- Pedido 11
(17, 11, 1, 119.90, 119.90),

-- Pedido 12
(18, 12, 1, 199.90, 199.90),

-- Pedido 13
(19, 13, 2, 59.90, 119.80),

-- Pedido 14
(20, 14, 1, 149.90, 149.90),

-- Pedido 15
(1, 15, 1, 39.90, 39.90),
(2, 15, 1, 59.90, 59.90),

-- Pedido 16
(3, 16, 2, 89.90, 179.80),

-- Pedido 17
(4, 17, 1, 79.90, 79.90),
(5, 17, 1, 69.90, 69.90),

-- Pedido 18
(6, 18, 1, 45.90, 45.90),
(7, 18, 1, 129.90, 129.90),

-- Pedido 19
(8, 19, 1, 139.90, 139.90),
(9, 19, 1, 34.90, 34.90),

-- Pedido 20
(10, 20, 1, 36.90, 36.90),
(11, 20, 2, 49.90, 99.80);

-- =========================
-- DEVOLUÇÕES
-- =========================
INSERT INTO devolucoes (pedido_id, cliente_id, motivo, tipo_devolucao_id, status_id, data_decisao, usuario_responsavel)
VALUES
(1, 2, 'Cliente devolveu apenas um dos itens por defeito', 1, 1, NULL, 1),
(2, 3, 'Pedido devolvido integralmente por desistência', 2, 2, NOW(), 1),
(3, 4, 'Produto incorreto enviado, devolução parcial', 1, 2, NOW(), 1),
(4, 5, 'Cliente não ficou satisfeito, devolução total', 2, 3, NOW(), 1),
(5, 6, 'Produto com embalagem danificada, devolução parcial', 1, 1, NULL, 1),
(6, 7, 'Cliente alegou alergia, devolução total', 2, 2, NOW(), 1),
(7, 8, 'Produto entregue fora do prazo, devolução parcial', 1, 3, NOW(), 1),
(9, 10, 'Itens faltando na caixa, devolução total', 2, 1, NULL, 1);

-- =========================
-- ITENS DEVOLUÇÃO
-- =========================
INSERT INTO itens_devolucao (item_pedido_id, devolucao_id, quantidade, subtotal)
VALUES
-- Devolução 9 (pedido 1, parcial)
(1, 9, 1, 39.90),
(2, 9, 1, 59.90),

-- Devolução 10 (pedido 2, total)
(3, 10, 1, 89.90),

-- Devolução 11 (pedido 3, parcial)
(4, 11, 1, 79.90),
(5, 11, 1, 69.90),

-- Devolução 12 (pedido 4, total)
(6, 12, 1, 45.90),
(7, 12, 1, 129.90),

-- Devolução 13 (pedido 5, parcial)
(8, 13, 1, 139.90),

-- Devolução 14 (pedido 6, total)
(9, 14, 1, 34.90),
(10, 14, 1, 36.90),

-- Devolução 15 (pedido 7, parcial)
(11, 15, 1, 49.90),

-- Devolução 16 (pedido 9, total)
(12, 16, 1, 38.70);


-- =========================
-- COMISSÕES
-- =========================
INSERT INTO comissoes (consultora_id, saldo_liquido)
VALUES
(1, 250.75),
(2, 320.50),
(3, 150.00),
(4, 410.20),
(5, 275.90),
(6, 360.00),
(7, 198.45),
(8, 420.80),
(9, 305.60),
(10, 289.99),
(11, 512.30),
(12, 333.33),
(13, 278.40),
(14, 450.00),
(15, 390.10),
(16, 210.25),
(17, 365.75),
(18, 480.90),
(19, 299.99),
(20, 530.50);

-- =========================
-- HISTÓRICO COMISSÕES
-- =========================
INSERT INTO historico_comissoes (consultora_id, pedido_id, tipo_comissao_id, valor, tipo_movimentacao_id, usuario_responsavel)
VALUES
-- Vendas diretas
(2, 1, 1, 59.97, 1, 1),   -- 30% de 199.90
(3, 2, 1, 26.97, 1, 1),   -- 30% de 89.90
(4, 3, 1, 17.97, 1, 1),   -- 30% de 59.90
(5, 4, 1, 44.97, 1, 1),   -- 30% de 149.90
(6, 5, 1, 23.97, 1, 1),   -- 30% de 79.90
(7, 6, 1, 38.97, 1, 1),   -- 30% de 129.90
(8, 7, 1, 11.97, 1, 1),   -- 30% de 39.90
(9, 8, 1, 74.97, 1, 1),   -- 30% de 249.90
(10, 9, 1, 29.97, 1, 1),  -- 30% de 99.90
(11, 10, 1, 17.97, 1, 1), -- 30% de 59.90

-- Estornos por devolução
(2, 1, 1, -39.90, 2, 1),  -- devolução parcial pedido 1
(3, 2, 1, -89.90, 2, 1),  -- devolução total pedido 2
(4, 3, 1, -59.90, 2, 1),  -- devolução parcial pedido 3
(5, 4, 1, -149.90, 2, 1), -- devolução total pedido 4
(6, 5, 1, -79.90, 2, 1),  -- devolução parcial pedido 5
(7, 6, 1, -129.90, 2, 1), -- devolução total pedido 6
(8, 7, 1, -39.90, 2, 1),  -- devolução parcial pedido 7
(10, 9, 1, -99.90, 2, 1), -- devolução total pedido 9

-- Saques (sem pedido vinculado)
(2, NULL, 3, 100.00, 3, 1),
(3, NULL, 3, 150.00, 3, 1);

-- =========================
-- SOLICITAÇÕES SAQUE
-- =========================
INSERT INTO solicitacoes_saque (consultora_id, valor_solicitado, status_id, data_decisao)
VALUES
(2, 150.00, 1, NULL),   -- pendente
(3, 200.00, 2, NOW()),  -- aprovada
(4, 120.00, 3, NOW()),  -- rejeitada
(5, 300.00, 2, NOW()),
(6, 180.00, 1, NULL),
(7, 250.00, 2, NOW()),
(8, 90.00, 3, NOW()),
(9, 400.00, 2, NOW()),
(10, 220.00, 1, NULL),
(11, 350.00, 2, NOW()),
(12, 175.00, 3, NOW()),
(13, 280.00, 2, NOW()),
(14, 95.00, 1, NULL),
(15, 310.00, 2, NOW()),
(16, 140.00, 3, NOW()),
(17, 260.00, 2, NOW()),
(18, 330.00, 1, NULL),
(19, 210.00, 2, NOW()),
(20, 500.00, 2, NOW());

-- =========================
-- CATÁLOGOS
-- =========================
INSERT INTO catalogos (nome, tipo_catalogo_id, status_id, descricao, data_publicacao, data_encerramento)
VALUES
('Catálogo Verão 2026', 2, 1, 'Produtos de beleza para o verão', '2026-01-10', '2026-03-31'),
('Catálogo Pontos Bronze', 1, 1, 'Resgate de pontos nível bronze', '2026-01-15', '2026-06-30'),
('Catálogo Especial Dia das Mães', 2, 2, 'Promoções especiais para o Dia das Mães', '2026-04-20', '2026-05-15');

-- =========================
-- ITENS CATÁLOGO
-- =========================
INSERT INTO itens_catalogo (preco, pontos_necessarios, status_id, estoque_disponivel, catalogo_id, produto_id)
VALUES
-- Catálogo Verão 2026 (vendas)
(39.90, NULL, 1, 100, 1, 1),
(59.90, NULL, 1, 80, 1, 2),
(89.90, NULL, 2, 0, 1, 3),
(79.90, NULL, 1, 50, 1, 4),

-- Catálogo Pontos Bronze (recompensas)
(39.90, 400, 1, 100, 2, 1),
(59.90, 600, 1, 80, 2, 2),
(129.90, 1300, 1, 40, 2, 7),
(139.90, 1400, 2, 0, 2, 8),

-- Catálogo Especial Dia das Mães (vendas)
(34.90, NULL, 1, 120, 3, 9),
(36.90, NULL, 1, 110, 3, 10),
(49.90, NULL, 2, 0, 3, 11),
(12.90, NULL, 1, 200, 3, 12);

-- =========================
-- RESGATES
-- =========================
INSERT INTO resgates (total_pontos, consultora_id, catalogo_id, data, status_id, usuario_responsavel)
VALUES
(400, 2, 2, '2026-02-01 10:15:00', 1, 1),   -- pendente
(600, 3, 2, '2026-02-02 14:20:00', 2, 1),   -- aprovada
(800, 4, 2, '2026-02-03 09:45:00', 3, 1),   -- cancelada
(1200, 5, 2, '2026-02-04 11:30:00', 2, 1),
(500, 6, 2, '2026-02-05 16:10:00', 1, 1),
(700, 7, 2, '2026-02-06 13:00:00', 2, 1),
(900, 8, 2, '2026-02-07 15:25:00', 3, 1),
(1000, 9, 2, '2026-02-08 17:40:00', 2, 1),
(450, 10, 2, '2026-02-09 12:05:00', 1, 1),
(650, 11, 2, '2026-02-10 18:15:00', 2, 1),
(750, 12, 2, '2026-02-11 19:00:00', 3, 1),
(850, 13, 2, '2026-02-12 20:10:00', 2, 1),
(950, 14, 2, '2026-02-13 09:20:00', 1, 1),
(1050, 15, 2, '2026-02-14 10:30:00', 2, 1),
(1150, 16, 2, '2026-02-15 11:45:00', 3, 1),
(300, 2, 2, '2026-02-16 12:00:00', 2, 1),
(500, 3, 2, '2026-02-17 13:15:00', 1, 1),
(700, 4, 2, '2026-02-18 14:25:00', 2, 1),
(900, 5, 2, '2026-02-19 15:35:00', 3, 1),
(1100, 6, 2, '2026-02-20 16:45:00', 2, 1);

-- =========================
-- ITENS RESGATE
-- =========================
INSERT INTO itens_resgate (quantidade, item_catalogo_id, resgate_id, subtotal_pontos)
VALUES
-- Batom Matte Vermelho (400 pontos cada)
(1, 5, 1, 400),
(2, 5, 2, 800),
(1, 5, 3, 400),
(3, 5, 4, 1200),

-- Base Líquida (600 pontos cada)
(1, 6, 5, 600),
(2, 6, 6, 1200),
(1, 6, 7, 600),
(3, 6, 8, 1800),

-- Perfume Floral (1300 pontos cada)
(1, 7, 9, 1300),
(2, 7, 10, 2600),
(1, 7, 11, 1300),
(3, 7, 12, 3900),

-- Perfume Amadeirado (1400 pontos cada)
(1, 8, 13, 1400),
(2, 8, 14, 2800),
(1, 8, 15, 1400),
(3, 8, 16, 4200),

-- Mistura de itens em resgates posteriores
(1, 5, 17, 400),
(1, 6, 18, 600),
(1, 7, 19, 1300),
(1, 8, 20, 1400);

-- =========================
-- PROMOÇÕES
-- =========================
INSERT INTO promocoes (nome, desconto, descricao, tipo_promocao_id, data_inicio, data_fim, status_id)
VALUES
('Promoção Carnaval 2026', 20.00, 'Desconto de 20% em toda a linha de maquiagem', 1, '2026-02-01', '2026-02-15', 1),
('Semana da Beleza', 15.00, 'Desconto fixo de R$15 em hidratantes faciais', 2, '2026-03-01', '2026-03-10', 1),
('Brinde Dia das Mães', 0.00, 'Na compra de perfumes, leve um batom grátis', 3, '2026-04-20', '2026-05-15', 2),
('Frete Grátis Outono', 0.00, 'Frete grátis em compras acima de R$100', 4, '2026-03-01', '2026-03-31', 1),
('Black Friday 2026', 50.00, 'Desconto de 50% em produtos selecionados', 1, '2026-11-01', '2026-11-30', 3),
('Natal Encantado', 30.00, 'Desconto fixo de R$30 em kits de presente', 2, '2026-12-01', '2026-12-25', 1);

-- =========================
-- ITENS PROMOÇÃO
-- =========================
INSERT INTO itens_promocao (produto_id, promocao_id, quantidade_min, condicao_especial)
VALUES
-- Promoção Carnaval 2026 (20% desconto)
(5, 1, 1, 'Desconto aplicado automaticamente'),
(6, 1, 2, 'Na compra de 2 unidades'),

-- Semana da Beleza (R$15 fixo em hidratantes)
(16, 2, 1, 'Desconto fixo em hidratante anti-idade'),
(19, 2, 1, 'Desconto fixo em hidratante orgânico'),

-- Brinde Dia das Mães
(7, 3, 1, 'Na compra do perfume, ganha batom'),
(20, 3, 1, 'Kit presente com brinde especial'),

-- Frete Grátis Outono
(13, 4, 2, 'Frete grátis acima de R$100'),
(14, 4, 3, 'Frete grátis para 3 unidades'),

-- Black Friday 2026 (50% desconto)
(15, 5, 1, 'Desconto especial Black Friday'),
(18, 5, 1, 'Kit maquiagem com 50% off'),

-- Natal Encantado (R$30 fixo em kits)
(17, 6, 1, 'Sérum com desconto natalino'),
(20, 6, 1, 'Kit presente com desconto natalino');

-- =========================
-- METAS
-- =========================
INSERT INTO metas (consultora_id, lider_id, valor_meta, data_referencia, status_id)
VALUES
(2, 17, 1500.00, '2026-01-31', 1),
(3, 17, 2000.00, '2026-01-31', 2),
(4, 18, 1800.00, '2026-02-28', 3),  -- corrigido
(5, 18, 2200.00, '2026-02-28', 1),  -- corrigido
(6, 19, 2500.00, '2026-03-31', 2),
(7, 19, 1200.00, '2026-03-31', 1),
(8, 20, 3000.00, '2026-04-30', 3),
(9, 20, 1700.00, '2026-04-30', 2),
(10, 17, 900.00, '2026-05-31', 1),
(11, 18, 1300.00, '2026-05-31', 3),
(12, 19, 2100.00, '2026-06-30', 2),
(13, 20, 1600.00, '2026-06-30', 1),
(14, 17, 2800.00, '2026-07-31', 3),
(15, 18, 1900.00, '2026-07-31', 2),
(16, 19, 2400.00, '2026-08-31', 1);

-- =========================
-- LOGS
-- =========================
INSERT INTO logs (usuario_id, acao, entidade_afetada, registro_afetado_id, detalhes, ip_origem)
VALUES
(1, 'inserção', 'pedidos', 1, 'Pedido criado pelo cliente 2', '192.168.0.10'),
(2, 'atualização', 'devolucoes', 9, 'Status da devolução alterado para aprovado', '192.168.0.11'),
(3, 'inserção', 'comissoes', 5, 'Comissão gerada por venda direta', '192.168.0.12'),
(4, 'exclusão', 'itens_devolucao', 3, 'Item de devolução removido por erro', '192.168.0.13'),
(5, 'inserção', 'resgates', 2, 'Resgate de pontos solicitado', '192.168.0.14'),
(6, 'atualização', 'solicitacoes_saque', 7, 'Solicitação de saque aprovada', '192.168.0.15'),
(7, 'inserção', 'catalogos', 1, 'Novo catálogo de verão publicado', '192.168.0.16'),
(8, 'inserção', 'itens_catalogo', 5, 'Item Batom Matte adicionado ao catálogo de pontos', '192.168.0.17'),
(9, 'atualização', 'historico_comissoes', 12, 'Estorno de comissão registrado', '192.168.0.18'),
(10, 'inserção', 'promocoes', 3, 'Promoção Dia das Mães cadastrada', '192.168.0.19'),
(11, 'inserção', 'itens_promocao', 6, 'Produto Máscara de Argila vinculado à promoção Carnaval', '192.168.0.20'),
(12, 'atualização', 'metas', 4, 'Meta da consultora 4 marcada como atingida', '192.168.0.21'),
(13, 'inserção', 'logs', 1, 'Primeiro log de auditoria criado', '192.168.0.22'),
(14, 'exclusão', 'pedidos', 7, 'Pedido cancelado por desistência', '192.168.0.23'),
(15, 'inserção', 'resgates', 10, 'Resgate de perfume floral aprovado', '192.168.0.24'),
(16, 'atualização', 'comissoes', 14, 'Saldo líquido atualizado após saque', '192.168.0.25'),
(17, 'inserção', 'metas', 8, 'Meta criada para consultora 8', '192.168.0.26'),
(18, 'atualização', 'catalogos', 2, 'Catálogo Pontos Bronze prorrogado', '192.168.0.27'),
(19, 'inserção', 'itens_resgate', 5, 'Item Batom resgatado com 400 pontos', '192.168.0.28'),
(20, 'inserção', 'promocoes', 5, 'Promoção Black Friday cadastrada', '192.168.0.29'),

-- mais 20 registros para completar os 40
(1, 'inserção', 'pedidos', 12, 'Pedido criado pelo cliente 11', '192.168.0.30'),
(2, 'atualização', 'devolucoes', 13, 'Devolução parcial registrada', '192.168.0.31'),
(3, 'inserção', 'comissoes', 9, 'Comissão gerada por venda nível 1', '192.168.0.32'),
(4, 'exclusão', 'itens_devolucao', 8, 'Item de devolução removido por duplicidade', '192.168.0.33'),
(5, 'inserção', 'resgates', 15, 'Resgate de pontos cancelado', '192.168.0.34'),
(6, 'atualização', 'solicitacoes_saque', 12, 'Solicitação de saque rejeitada', '192.168.0.35'),
(7, 'inserção', 'catalogos', 3, 'Catálogo Dia das Mães publicado', '192.168.0.36'),
(8, 'inserção', 'itens_catalogo', 7, 'Perfume Floral adicionado ao catálogo de pontos', '192.168.0.37'),
(9, 'atualização', 'historico_comissoes', 18, 'Saque registrado no histórico', '192.168.0.38'),
(10, 'inserção', 'promocoes', 6, 'Promoção Natal Encantado cadastrada', '192.168.0.39'),
(11, 'inserção', 'itens_promocao', 15, 'Esfoliante Corporal vinculado à promoção Black Friday', '192.168.0.40'),
(12, 'atualização', 'metas', 12, 'Meta da consultora 12 não atingida', '192.168.0.41'),
(13, 'inserção', 'logs', 20, 'Log de auditoria adicional criado', '192.168.0.42'),
(14, 'exclusão', 'pedidos', 16, 'Pedido cancelado por devolução total', '192.168.0.43'),
(15, 'inserção', 'resgates', 18, 'Resgate de sérum rejuvenescedor aprovado', '192.168.0.44'),
(16, 'atualização', 'comissoes', 20, 'Saldo líquido atualizado após estorno', '192.168.0.45'),
(17, 'inserção', 'metas', 14, 'Meta criada para consultora 14', '192.168.0.46'),
(18, 'atualização', 'catalogos', 1, 'Catálogo Verão encerrado', '192.168.0.47'),
(19, 'inserção', 'itens_resgate', 12, 'Item Base Líquida resgatado com 600 pontos', '192.168.0.48'),
(20, 'inserção', 'promocoes', 2, 'Promoção Semana da Beleza cadastrada', '192.168.0.49');

-- =========================
-- Qualificação Profissional
-- =========================
INSERT INTO qualificacao_profissional (consultora_id, data_validacao, data_referencia, total_vendas, recrutas_ativos_totais, status)
VALUES
(2, '2026-01-31', '2026-01-31', 2500.00, 3, 'promovido'),
(3, '2026-01-31', '2026-01-31', 1800.00, 2, 'mantida'),
(4, '2026-02-28', '2026-02-28', 3200.00, 4, 'promovido'),
(5, '2026-02-28', '2026-02-28', 900.00, 1, 'rebaixado'),
(6, '2026-03-31', '2026-03-31', 1500.00, 0, 'pendente'),
(7, '2026-03-31', '2026-03-31', 2800.00, 5, 'mantida'),
(8, '2026-04-30', '2026-04-30', 4100.00, 6, 'promovido'),
(9, '2026-04-30', '2026-04-30', 1200.00, 2, 'rebaixado'),
(10, '2026-05-31', '2026-05-31', 2300.00, 3, 'mantida'),
(11, '2026-05-31', '2026-05-31', 800.00, 1, 'pendente'),
(12, '2026-06-30', '2026-06-30', 3500.00, 7, 'promovido'),
(13, '2026-06-30', '2026-06-30', 1700.00, 2, 'mantida'),
(14, '2026-07-31', '2026-07-31', 2600.00, 4, 'promovido'),
(15, '2026-07-31', '2026-07-31', 950.00, 0, 'rebaixado'),
(16, '2026-08-31', '2026-08-31', 4200.00, 8, 'promovido');

-- =========================
-- historico_cargo
-- =========================
INSERT INTO historico_cargo (consultora_id, qualificacao_profissional_id, cargo_anterior, cargo_novo, data_mudanca)
VALUES
(2, 1, 1, 2, '2026-01-31 10:00:00'),   -- Consultora → Líder
(3, 2, 1, 1, '2026-01-31 11:15:00'),   -- Consultora mantida
(4, 3, 1, 2, '2026-02-28 09:30:00'),   -- Consultora → Líder
(5, 4, 2, 1, '2026-02-28 14:45:00'),   -- Líder → Consultora (rebaixada)
(6, 5, 1, 1, '2026-03-31 16:20:00'),   -- Consultora mantida
(7, 6, 2, 2, '2026-03-31 17:00:00'),   -- Líder mantido
(8, 7, 1, 2, '2026-04-30 12:10:00'),   -- Consultora → Líder
(9, 8, 2, 1, '2026-04-30 13:25:00'),   -- Líder → Consultora
(10, 9, 1, 2, '2026-05-31 09:50:00'),  -- Consultora → Líder
(11, 10, 1, 1, '2026-05-31 15:40:00'), -- Consultora mantida
(12, 11, 2, 1, '2026-06-30 10:20:00'), -- Líder → Consultora
(13, 12, 1, 2, '2026-06-30 11:45:00'); -- Consultora → Líder

-- =========================
-- pagamentos
-- =========================
INSERT INTO pagamentos (pedido_id, tipo_pagamento, valor, status, codigo_transacao, data_solicitacao, data_confirmacao, usuario_responsavel)
VALUES
(1, 'credito', 199.90, 'aprovado', 'TX1001ABC', '2026-02-24 19:18:18', '2026-02-24 19:20:00', 1),
(2, 'pix', 89.90, 'pendente', 'TX1002DEF', '2026-02-24 19:18:18', NULL, 1),
(3, 'debito', 59.90, 'aprovado', 'TX1003GHI', '2026-02-24 19:18:18', '2026-02-24 19:19:30', 1),
(4, 'credito', 149.90, 'recusado', 'TX1004JKL', '2026-02-24 19:18:18', NULL, 1),
(5, 'pix', 79.90, 'aprovado', 'TX1005MNO', '2026-02-24 19:18:18', '2026-02-24 19:21:00', 1),
(6, 'debito', 129.90, 'em_analise', 'TX1006PQR', '2026-02-24 19:18:18', NULL, 1),
(7, 'credito', 39.90, 'aprovado', 'TX1007STU', '2026-02-24 19:18:18', '2026-02-24 19:19:50', 1),
(8, 'pix', 249.90, 'pendente', 'TX1008VWX', '2026-02-24 19:18:18', NULL, 1),
(9, 'debito', 99.90, 'aprovado', 'TX1009YZA', '2026-02-24 19:18:18', '2026-02-24 19:20:10', 1),
(10, 'credito', 59.90, 'estornado', 'TX1010BCD', '2026-02-24 19:18:18', '2026-02-25 10:00:00', 1),
(11, 'pix', 179.90, 'aprovado', 'TX1011EFG', '2026-02-24 19:18:18', '2026-02-24 19:22:00', 1),
(12, 'debito', 119.90, 'pendente', 'TX1012HIJ', '2026-02-24 19:18:18', NULL, 1),
(13, 'credito', 89.90, 'aprovado', 'TX1013KLM', '2026-02-24 19:18:18', '2026-02-24 19:20:40', 1),
(14, 'pix', 139.90, 'recusado', 'TX1014NOP', '2026-02-24 19:18:18', NULL, 1),
(15, 'debito', 49.90, 'aprovado', 'TX1015QRS', '2026-02-24 19:18:18', '2026-02-24 19:19:10', 1),
(16, 'credito', 229.90, 'em_analise', 'TX1016TUV', '2026-02-24 19:18:18', NULL, 1),
(17, 'pix', 109.90, 'aprovado', 'TX1017WXY', '2026-02-24 19:18:18', '2026-02-24 19:21:30', 1),
(18, 'debito', 69.90, 'pendente', 'TX1018ZAB', '2026-02-24 19:18:18', NULL, 1),
(19, 'credito', 199.90, 'aprovado', 'TX1019CDE', '2026-02-24 19:18:18', '2026-02-24 19:22:15', 1),
(20, 'pix', 159.90, 'aprovado', 'TX1020FGH', '2026-02-24 19:18:18', '2026-02-24 19:23:00', 1);
