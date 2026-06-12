-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2026 at 07:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_ale`
--

-- --------------------------------------------------------

--
-- Table structure for table `catalogos`
--

CREATE TABLE `catalogos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo_catalogo_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_encerramento` datetime DEFAULT NULL,
  `data_publicacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES
(1, 'Maquiagem', 'Produtos para realçar a beleza facial, como bases, pós e corretivos'),
(2, 'Batons', 'Diversas cores e acabamentos para os lábios'),
(3, 'Sombras', 'Paletas e sombras unitárias para olhos'),
(4, 'Máscaras de Cílios', 'Produtos para alongar e dar volume aos cílios'),
(5, 'Cuidados com a Pele', 'Cremes e loções para hidratação e proteção da pele'),
(6, 'Hidratantes Faciais', 'Produtos específicos para hidratar o rosto'),
(7, 'Protetores Solares', 'Filtros solares para proteção contra raios UV'),
(8, 'Perfumes', 'Fragrâncias femininas e masculinas'),
(9, 'Desodorantes', 'Produtos para controle de odor e transpiração'),
(10, 'Shampoos', 'Produtos para limpeza dos cabelos'),
(11, 'Condicionadores', 'Produtos para hidratação e maciez dos fios'),
(12, 'Máscaras Capilares', 'Tratamentos intensivos para cabelos'),
(13, 'Óleos Corporais', 'Óleos hidratantes e nutritivos para pele'),
(14, 'Sabonetes', 'Sabonetes líquidos e em barra para higiene pessoal'),
(15, 'Esmaltes', 'Produtos para colorir e fortalecer unhas'),
(16, 'Removedores de Maquiagem', 'Produtos para limpeza da pele e remoção de maquiagem'),
(17, 'Tônicos Faciais', 'Soluções para equilibrar e preparar a pele'),
(18, 'Séruns', 'Tratamentos concentrados para pele e cabelos'),
(19, 'Acessórios de Beleza', 'Pincéis, esponjas e outros acessórios'),
(20, 'Kits de Cuidados', 'Conjuntos de produtos para tratamento completo');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `consultora_id` int(11) NOT NULL,
  `cpf` char(11) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comissoes`
--

CREATE TABLE `comissoes` (
  `id` int(11) NOT NULL,
  `consultora_id` int(11) NOT NULL,
  `saldo_liquido` decimal(10,2) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `modificado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devolucoes`
--

CREATE TABLE `devolucoes` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `tipo_devolucao_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `data_decisao` datetime DEFAULT NULL,
  `data_solicitacao` datetime DEFAULT current_timestamp(),
  `usuario_responsavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estoque`
--

CREATE TABLE `estoque` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `modificado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historico_cargo`
--

CREATE TABLE `historico_cargo` (
  `id` int(11) NOT NULL,
  `consultora_id` int(11) NOT NULL,
  `qualificacao_profissional_id` int(11) NOT NULL,
  `cargo_anterior` int(11) NOT NULL,
  `cargo_novo` int(11) DEFAULT NULL,
  `data_mudanca` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historico_comissoes`
--

CREATE TABLE `historico_comissoes` (
  `id` int(11) NOT NULL,
  `consultora_id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `tipo_comissao_id` int(11) NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tipo_movimentacao_id` int(11) NOT NULL,
  `data_movimentacao` datetime DEFAULT current_timestamp(),
  `usuario_responsavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historico_status_pedido`
--

CREATE TABLE `historico_status_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `data_mudanca` datetime DEFAULT current_timestamp(),
  `usuario_responsavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itens_catalogo`
--

CREATE TABLE `itens_catalogo` (
  `id` int(11) NOT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `pontos_necessarios` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `estoque_disponivel` int(11) DEFAULT NULL,
  `catalogo_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itens_devolucao`
--

CREATE TABLE `itens_devolucao` (
  `id` int(11) NOT NULL,
  `item_pedido_id` int(11) NOT NULL,
  `devolucao_id` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `preco_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itens_promocao`
--

CREATE TABLE `itens_promocao` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `promocao_id` int(11) NOT NULL,
  `quantidade_min` int(11) DEFAULT NULL,
  `condicao_especial` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itens_resgate`
--

CREATE TABLE `itens_resgate` (
  `id` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `item_catalogo_id` int(11) NOT NULL,
  `resgate_id` int(11) NOT NULL,
  `subtotal_pontos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `acao` varchar(100) DEFAULT NULL,
  `entidade_afetada` varchar(100) DEFAULT NULL,
  `registro_afetado_id` int(11) DEFAULT NULL,
  `data_hora` datetime DEFAULT current_timestamp(),
  `detalhes` text DEFAULT NULL,
  `ip_origem` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE `metas` (
  `id` int(11) NOT NULL,
  `consultora_id` int(11) NOT NULL,
  `lider_id` int(11) DEFAULT NULL,
  `valor_meta` decimal(10,2) DEFAULT NULL,
  `data_referencia` date DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movimentacao_estoque`
--

CREATE TABLE `movimentacao_estoque` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `origem_tipo` varchar(50) DEFAULT NULL,
  `origem_id` int(11) DEFAULT NULL,
  `tipo_movimentacao_id` int(11) NOT NULL,
  `usuario_responsavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `tipo_pagamento` enum('credito','debito','pix') NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status` enum('pendente','aprovado','recusado','estornado','em_analise') NOT NULL,
  `codigo_transacao` varchar(100) DEFAULT NULL,
  `data_solicitacao` datetime NOT NULL,
  `data_confirmacao` datetime DEFAULT NULL,
  `usuario_responsavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `tipo_pagamento` enum('credito','debito','pix') NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `modificado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `modificado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `descricao`, `categoria_id`, `status_id`, `imagem_url`, `criado_em`, `modificado_em`) VALUES
(1, 'Base Líquida Matte', 59.90, 'Base líquida com acabamento matte e longa duração', 1, 1, 'img/base_liquida.jpg', '2026-02-24 12:49:18', NULL),
(2, 'Corretivo Alta Cobertura', 39.90, 'Corretivo líquido para olheiras e manchas', 1, 1, 'img/corretivo.jpg', '2026-02-24 12:49:18', NULL),
(3, 'Batom Vermelho Intenso', 29.90, 'Batom cremoso com alta pigmentação', 2, 1, 'img/batom_vermelho.jpg', '2026-02-24 12:49:18', NULL),
(4, 'Batom Nude Elegante', 27.90, 'Batom hidratante com acabamento suave', 2, 2, 'img/batom_nude.jpg', '2026-02-24 12:49:18', NULL),
(5, 'Paleta de Sombras Neutras', 89.90, 'Paleta com 12 cores neutras e pigmentadas', 3, 1, 'img/paleta_neutra.jpg', '2026-02-24 12:49:18', NULL),
(6, 'Máscara de Cílios Volume Extra', 49.90, 'Máscara para cílios com efeito volumoso', 4, 1, 'img/mascara_cilios.jpg', '2026-02-24 12:49:18', NULL),
(7, 'Creme Hidratante Facial', 69.90, 'Hidratante leve para uso diário', 5, 1, 'img/hidratante_facial.jpg', '2026-02-24 12:49:18', NULL),
(8, 'Gel de Limpeza Facial', 54.90, 'Gel suave para limpeza profunda da pele', 5, 2, 'img/gel_limpeza.jpg', '2026-02-24 12:49:18', NULL),
(9, 'Perfume Floral Feminino', 129.90, 'Fragrância suave e delicada com notas florais', 8, 1, 'img/perfume_feminino.jpg', '2026-02-24 12:49:18', NULL),
(10, 'Perfume Amadeirado Masculino', 139.90, 'Fragrância intensa com notas amadeiradas', 8, 1, 'img/perfume_masculino.jpg', '2026-02-24 12:49:18', NULL),
(11, 'Shampoo Nutritivo', 34.90, 'Shampoo para cabelos secos e danificados', 10, 1, 'img/shampoo_nutritivo.jpg', '2026-02-24 12:49:18', NULL),
(12, 'Condicionador Reparador', 36.90, 'Condicionador para hidratação profunda', 11, 1, 'img/condicionador_reparador.jpg', '2026-02-24 12:49:18', NULL),
(13, 'Máscara Capilar Reconstrutora', 79.90, 'Tratamento intensivo para fios quebradiços', 12, 2, 'img/mascara_reconstrutora.jpg', '2026-02-24 12:49:18', NULL),
(14, 'Esmalte Rosa Chiclete', 12.90, 'Esmalte com alta durabilidade e brilho', 15, 1, 'img/esmalte_rosa.jpg', '2026-02-24 12:49:18', NULL),
(15, 'Esmalte Preto Clássico', 12.90, 'Esmalte cremoso de longa duração', 15, 2, 'img/esmalte_preto.jpg', '2026-02-24 12:49:18', NULL),
(16, 'Sérum Anti-Idade', 99.90, 'Sérum facial com ácido hialurônico e vitamina C', 18, 1, 'img/serum_antiidade.jpg', '2026-02-24 12:49:18', NULL),
(17, 'Kit de Pincéis Profissionais', 149.90, 'Conjunto com 12 pincéis para maquiagem', 19, 1, 'img/pinceis.jpg', '2026-02-24 12:49:18', NULL),
(18, 'Kit Cuidados com a Pele', 199.90, 'Conjunto com hidratante, tônico e sérum', 20, 1, 'img/kit_pele.jpg', '2026-02-24 12:49:18', NULL),
(19, 'Kit Maquiagem Básico', 179.90, 'Conjunto com base, batom e máscara de cílios', 20, 2, 'img/kit_maquiagem.jpg', '2026-02-24 12:49:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promocoes`
--

CREATE TABLE `promocoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `tipo_promocao_id` int(11) NOT NULL,
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualificacao_profissional`
--

CREATE TABLE `qualificacao_profissional` (
  `id` int(11) NOT NULL,
  `consultora_id` int(11) NOT NULL,
  `data_validacao` date DEFAULT NULL,
  `data_referencia` date DEFAULT NULL,
  `total_vendas` decimal(10,2) DEFAULT NULL,
  `recrutas_ativos_totais` int(11) DEFAULT NULL,
  `status` enum('promovido','rebaixado','pendente','mantida') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resgates`
--

CREATE TABLE `resgates` (
  `id` int(11) NOT NULL,
  `total_pontos` int(11) DEFAULT NULL,
  `consultora_id` int(11) NOT NULL,
  `catalogo_id` int(11) NOT NULL,
  `data` datetime DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `usuario_responsavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `solicitacoes_saque`
--

CREATE TABLE `solicitacoes_saque` (
  `id` int(11) NOT NULL,
  `consultora_id` int(11) NOT NULL,
  `valor_solicitado` decimal(10,2) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `data_decisao` datetime DEFAULT NULL,
  `data_solicitacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_catalogo`
--

CREATE TABLE `status_catalogo` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_catalogo`
--

INSERT INTO `status_catalogo` (`id`, `nome`, `descricao`) VALUES
(1, 'Ativo', 'Catálogo ativo e disponível'),
(2, 'Inativo', 'Catálogo inativo e indisponível');

-- --------------------------------------------------------

--
-- Table structure for table `status_consultoras`
--

CREATE TABLE `status_consultoras` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_consultoras`
--

INSERT INTO `status_consultoras` (`id`, `nome`, `descricao`) VALUES
(1, 'Ativa', 'Consultora com vendas válidas no més vigente'),
(2, 'Inativa', 'Consultora que não atingiu o minimo de vendas e foi desativada');

-- --------------------------------------------------------

--
-- Table structure for table `status_devolucao`
--

CREATE TABLE `status_devolucao` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_devolucao`
--

INSERT INTO `status_devolucao` (`id`, `nome`, `descricao`) VALUES
(1, 'Pendente', 'Devolução aguardando análise'),
(2, 'Aprovada', 'Devolução aprovada'),
(3, 'Rejeitada', 'Devolução rejeitada');

-- --------------------------------------------------------

--
-- Table structure for table `status_item_catalogo`
--

CREATE TABLE `status_item_catalogo` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_item_catalogo`
--

INSERT INTO `status_item_catalogo` (`id`, `nome`, `descricao`) VALUES
(1, 'Disponível', 'Item disponível para compra'),
(2, 'Indisponível', 'Item indisponível para compra');

-- --------------------------------------------------------

--
-- Table structure for table `status_meta`
--

CREATE TABLE `status_meta` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_meta`
--

INSERT INTO `status_meta` (`id`, `nome`, `descricao`) VALUES
(1, 'Atingida', 'Meta foi atingida'),
(2, 'Não atingida', 'Meta não foi atingida'),
(3, 'Ativa', 'Meta está ativa');

-- --------------------------------------------------------

--
-- Table structure for table `status_pedido`
--

CREATE TABLE `status_pedido` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_pedido`
--

INSERT INTO `status_pedido` (`id`, `nome`, `descricao`) VALUES
(1, 'Aguardando Pagamento', 'Pedido aguardando confirmação de pagamento'),
(2, 'Pagamento Confirmado', 'Pagamento foi confirmado'),
(3, 'Separando Pedido', 'Pedido sendo separado no estoque'),
(4, 'Pronto para Envio', 'Pedido pronto para ser enviado'),
(5, 'Enviado', 'Pedido foi enviado'),
(6, 'Entregue', 'Pedido entregue ao cliente'),
(7, 'Cancelado', 'Pedido cancelado');

-- --------------------------------------------------------

--
-- Table structure for table `status_produto`
--

CREATE TABLE `status_produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_produto`
--

INSERT INTO `status_produto` (`id`, `nome`, `descricao`) VALUES
(1, 'Ativo', 'Produto ativo e disponível para venda'),
(2, 'Inativo', 'Produto inativo'),
(3, 'Descontinuado', 'Produto descontinuado');

-- --------------------------------------------------------

--
-- Table structure for table `status_promocao`
--

CREATE TABLE `status_promocao` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_promocao`
--

INSERT INTO `status_promocao` (`id`, `nome`, `descricao`) VALUES
(1, 'Ativa', 'Promoção ativa'),
(2, 'Inativa', 'Promoção inativa'),
(3, 'Expirada', 'Promoção expirada');

-- --------------------------------------------------------

--
-- Table structure for table `status_resgate`
--

CREATE TABLE `status_resgate` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_resgate`
--

INSERT INTO `status_resgate` (`id`, `nome`, `descricao`) VALUES
(1, 'Pendente', 'Resgate aguardando aprovação'),
(2, 'Aprovada', 'Resgate aprovado'),
(3, 'Cancelado', 'Resgate cancelado');

-- --------------------------------------------------------

--
-- Table structure for table `status_solicitacao_saque`
--

CREATE TABLE `status_solicitacao_saque` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_solicitacao_saque`
--

INSERT INTO `status_solicitacao_saque` (`id`, `nome`, `descricao`) VALUES
(1, 'Pendente', 'Solicitação de saque aguardando aprovação'),
(2, 'Aprovada', 'Solicitação de saque aprovada'),
(3, 'Rejeitada', 'Solicitação de saque rejeitada');

-- --------------------------------------------------------

--
-- Table structure for table `tipos_comissao`
--

CREATE TABLE `tipos_comissao` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `taxa` decimal(5,2) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipos_comissao`
--

INSERT INTO `tipos_comissao` (`id`, `nome`, `taxa`, `descricao`) VALUES
(1, 'Venda Direta', 0.30, 'Comissão gerada por venda direta da consultora'),
(2, 'nivel 1', 0.05, 'Comissão gerada por venda da rede direta (1º nível)'),
(3, 'nivel 2', 0.02, 'Comissão gerada por venda da rede da sua rede (2º nível)'),
(4, 'administrativa', 0.02, 'taxa administrativa sobre cada venda');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_catalogo`
--

CREATE TABLE `tipo_catalogo` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_catalogo`
--

INSERT INTO `tipo_catalogo` (`id`, `nome`, `descricao`) VALUES
(1, 'recompensas', 'Catálogo de recompensas para resgate de pontos'),
(2, 'vendas', 'Catálogo de produtos disponíveis para venda');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_devolucao`
--

CREATE TABLE `tipo_devolucao` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_devolucao`
--

INSERT INTO `tipo_devolucao` (`id`, `nome`, `descricao`) VALUES
(1, 'parcial', 'Devolução parcial do pedido, onde apenas alguns itens são devolvidos'),
(2, 'total', 'Devolução total do pedido, onde todos os itens são devolvidos');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_movimentacao_comissao`
--

CREATE TABLE `tipo_movimentacao_comissao` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_movimentacao_comissao`
--

INSERT INTO `tipo_movimentacao_comissao` (`id`, `nome`, `descricao`) VALUES
(1, 'venda', 'Movimentação de comissão gerada por venda'),
(2, 'estorno', 'Movimentação de comissão gerada por estorno de venda, se a comissão ja tiver sido sacada, o valor do estorno será descontado do próximo saque'),
(3, 'saque', 'Movimentação de comissão gerada por solicitação de saque');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_movimentacao_estoque`
--

CREATE TABLE `tipo_movimentacao_estoque` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_movimentacao_estoque`
--

INSERT INTO `tipo_movimentacao_estoque` (`id`, `nome`, `descricao`) VALUES
(1, 'Entrada', 'Movimentação de entrada de estoque'),
(2, 'Saída', 'Movimentação de saída de estoque');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_promocao`
--

CREATE TABLE `tipo_promocao` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_promocao`
--

INSERT INTO `tipo_promocao` (`id`, `nome`, `descricao`) VALUES
(1, 'desconto percentual', 'Promoção que oferece um desconto percentual sobre o preço do produto'),
(2, 'desconto fixo', 'Promoção que oferece um desconto fixo em reais sobre o preço do produto'),
(3, 'brinde', 'Promoção que oferece um brinde na compra do produto'),
(4, 'frete grátis', 'Promoção que oferece frete grátis na compra do produto');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cargo` enum('consultora','lider','distribuidora') NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `consultora_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `modificado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cargo`, `email`, `telefone`, `senha`, `cep`, `consultora_id`, `status_id`, `criado_em`, `modificado_em`) VALUES
(1, 'Distribuidora Central', 'distribuidora', 'distribuidora@empresa.com', '85999990001', 'senha123', '60000-000', NULL, 1, '2026-02-24 12:44:00', NULL),
(2, 'Líder Ana Silva', 'lider', 'ana.silva@empresa.com', '85999990002', 'senha123', '60010-000', 1, 1, '2026-02-24 12:44:00', NULL),
(3, 'Líder João Souza', 'lider', 'joao.souza@empresa.com', '85999990003', 'senha123', '60020-000', 1, 1, '2026-02-24 12:44:00', NULL),
(4, 'Líder Maria Oliveira', 'lider', 'maria.oliveira@empresa.com', '85999990004', 'senha123', '60030-000', 1, 2, '2026-02-24 12:44:00', NULL),
(5, 'Consultora Carla Lima', 'consultora', 'carla.lima@empresa.com', '85999990005', 'senha123', '60100-000', 2, 1, '2026-02-24 12:44:00', NULL),
(6, 'Consultora Pedro Gomes', 'consultora', 'pedro.gomes@empresa.com', '85999990006', 'senha123', '60110-000', 2, 1, '2026-02-24 12:44:00', NULL),
(7, 'Consultora Júlia Rocha', 'consultora', 'julia.rocha@empresa.com', '85999990007', 'senha123', '60120-000', 3, 2, '2026-02-24 12:44:00', NULL),
(8, 'Consultora Marcos Dias', 'consultora', 'marcos.dias@empresa.com', '85999990008', 'senha123', '60130-000', 3, 1, '2026-02-24 12:44:00', NULL),
(9, 'Consultora Fernanda Alves', 'consultora', 'fernanda.alves@empresa.com', '85999990009', 'senha123', '60140-000', 4, 1, '2026-02-24 12:44:00', NULL),
(10, 'Consultora Lucas Pereira', 'consultora', 'lucas.pereira@empresa.com', '85999990010', 'senha123', '60150-000', 4, 2, '2026-02-24 12:44:00', NULL),
(11, 'Consultora Bianca Costa', 'consultora', 'bianca.costa@empresa.com', '85999990011', 'senha123', '60160-000', 2, 1, '2026-02-24 12:44:00', NULL),
(12, 'Consultora Rafael Nunes', 'consultora', 'rafael.nunes@empresa.com', '85999990012', 'senha123', '60170-000', 2, 2, '2026-02-24 12:44:00', NULL),
(13, 'Consultora Camila Torres', 'consultora', 'camila.torres@empresa.com', '85999990013', 'senha123', '60180-000', 3, 1, '2026-02-24 12:44:00', NULL),
(14, 'Consultora Felipe Martins', 'consultora', 'felipe.martins@empresa.com', '85999990014', 'senha123', '60190-000', 3, 1, '2026-02-24 12:44:00', NULL),
(15, 'Consultora Patrícia Mendes', 'consultora', 'patricia.mendes@empresa.com', '85999990015', 'senha123', '60200-000', 4, 2, '2026-02-24 12:44:00', NULL),
(16, 'Consultora André Barbosa', 'consultora', 'andre.barbosa@empresa.com', '85999990016', 'senha123', '60210-000', 4, 1, '2026-02-24 12:44:00', NULL),
(17, 'Consultora Larissa Freitas', 'consultora', 'larissa.freitas@empresa.com', '85999990017', 'senha123', '60220-000', 2, 1, '2026-02-24 12:44:00', NULL),
(18, 'Consultora Daniel Ribeiro', 'consultora', 'daniel.ribeiro@empresa.com', '85999990018', 'senha123', '60230-000', 3, 2, '2026-02-24 12:44:00', NULL),
(19, 'Consultora Juliana Fernandes', 'consultora', 'juliana.fernandes@empresa.com', '85999990019', 'senha123', '60240-000', 4, 1, '2026-02-24 12:44:00', NULL),
(20, 'Consultora Gabriel Lima', 'consultora', 'gabriel.lima@empresa.com', '85999990020', 'senha123', '60250-000', 2, 2, '2026-02-24 12:44:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catalogos`
--
ALTER TABLE `catalogos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_catalogo_id` (`tipo_catalogo_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `consultora_id` (`consultora_id`);

--
-- Indexes for table `comissoes`
--
ALTER TABLE `comissoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultora_id` (`consultora_id`);

--
-- Indexes for table `devolucoes`
--
ALTER TABLE `devolucoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `tipo_devolucao_id` (`tipo_devolucao_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `usuario_responsavel` (`usuario_responsavel`);

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Indexes for table `historico_cargo`
--
ALTER TABLE `historico_cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `historico_comissoes`
--
ALTER TABLE `historico_comissoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultora_id` (`consultora_id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `tipo_comissao_id` (`tipo_comissao_id`),
  ADD KEY `tipo_movimentacao_id` (`tipo_movimentacao_id`),
  ADD KEY `usuario_responsavel` (`usuario_responsavel`);

--
-- Indexes for table `historico_status_pedido`
--
ALTER TABLE `historico_status_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `usuario_responsavel` (`usuario_responsavel`);

--
-- Indexes for table `itens_catalogo`
--
ALTER TABLE `itens_catalogo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catalogo_id` (`catalogo_id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `itens_devolucao`
--
ALTER TABLE `itens_devolucao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_pedido_id` (`item_pedido_id`),
  ADD KEY `devolucao_id` (`devolucao_id`);

--
-- Indexes for table `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indexes for table `itens_promocao`
--
ALTER TABLE `itens_promocao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `promocao_id` (`promocao_id`);

--
-- Indexes for table `itens_resgate`
--
ALTER TABLE `itens_resgate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_catalogo_id` (`item_catalogo_id`),
  ADD KEY `resgate_id` (`resgate_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultora_id` (`consultora_id`),
  ADD KEY `lider_id` (`lider_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `tipo_movimentacao_id` (`tipo_movimentacao_id`),
  ADD KEY `usuario_responsavel` (`usuario_responsavel`);

--
-- Indexes for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `usuario_responsavel` (`usuario_responsavel`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `promocoes`
--
ALTER TABLE `promocoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_promocao_id` (`tipo_promocao_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `qualificacao_profissional`
--
ALTER TABLE `qualificacao_profissional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultora_id` (`consultora_id`);

--
-- Indexes for table `resgates`
--
ALTER TABLE `resgates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultora_id` (`consultora_id`),
  ADD KEY `catalogo_id` (`catalogo_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `usuario_responsavel` (`usuario_responsavel`);

--
-- Indexes for table `solicitacoes_saque`
--
ALTER TABLE `solicitacoes_saque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultora_id` (`consultora_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `status_catalogo`
--
ALTER TABLE `status_catalogo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_consultoras`
--
ALTER TABLE `status_consultoras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_devolucao`
--
ALTER TABLE `status_devolucao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_item_catalogo`
--
ALTER TABLE `status_item_catalogo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_meta`
--
ALTER TABLE `status_meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_pedido`
--
ALTER TABLE `status_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_produto`
--
ALTER TABLE `status_produto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_promocao`
--
ALTER TABLE `status_promocao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_resgate`
--
ALTER TABLE `status_resgate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_solicitacao_saque`
--
ALTER TABLE `status_solicitacao_saque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos_comissao`
--
ALTER TABLE `tipos_comissao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_catalogo`
--
ALTER TABLE `tipo_catalogo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_devolucao`
--
ALTER TABLE `tipo_devolucao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_movimentacao_comissao`
--
ALTER TABLE `tipo_movimentacao_comissao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_movimentacao_estoque`
--
ALTER TABLE `tipo_movimentacao_estoque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_promocao`
--
ALTER TABLE `tipo_promocao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `consultora_id` (`consultora_id`),
  ADD KEY `status_id` (`status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catalogos`
--
ALTER TABLE `catalogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comissoes`
--
ALTER TABLE `comissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devolucoes`
--
ALTER TABLE `devolucoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historico_cargo`
--
ALTER TABLE `historico_cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historico_comissoes`
--
ALTER TABLE `historico_comissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historico_status_pedido`
--
ALTER TABLE `historico_status_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itens_catalogo`
--
ALTER TABLE `itens_catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itens_devolucao`
--
ALTER TABLE `itens_devolucao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itens_promocao`
--
ALTER TABLE `itens_promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itens_resgate`
--
ALTER TABLE `itens_resgate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `promocoes`
--
ALTER TABLE `promocoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qualificacao_profissional`
--
ALTER TABLE `qualificacao_profissional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resgates`
--
ALTER TABLE `resgates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `solicitacoes_saque`
--
ALTER TABLE `solicitacoes_saque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_catalogo`
--
ALTER TABLE `status_catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_consultoras`
--
ALTER TABLE `status_consultoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_devolucao`
--
ALTER TABLE `status_devolucao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_item_catalogo`
--
ALTER TABLE `status_item_catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_meta`
--
ALTER TABLE `status_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_pedido`
--
ALTER TABLE `status_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `status_produto`
--
ALTER TABLE `status_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_promocao`
--
ALTER TABLE `status_promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_resgate`
--
ALTER TABLE `status_resgate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_solicitacao_saque`
--
ALTER TABLE `status_solicitacao_saque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipos_comissao`
--
ALTER TABLE `tipos_comissao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tipo_catalogo`
--
ALTER TABLE `tipo_catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipo_devolucao`
--
ALTER TABLE `tipo_devolucao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipo_movimentacao_comissao`
--
ALTER TABLE `tipo_movimentacao_comissao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tipo_movimentacao_estoque`
--
ALTER TABLE `tipo_movimentacao_estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tipo_promocao`
--
ALTER TABLE `tipo_promocao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `catalogos`
--
ALTER TABLE `catalogos`
  ADD CONSTRAINT `catalogos_ibfk_1` FOREIGN KEY (`tipo_catalogo_id`) REFERENCES `tipo_catalogo` (`id`),
  ADD CONSTRAINT `catalogos_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_catalogo` (`id`);

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `comissoes`
--
ALTER TABLE `comissoes`
  ADD CONSTRAINT `comissoes_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `devolucoes`
--
ALTER TABLE `devolucoes`
  ADD CONSTRAINT `devolucoes_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `devolucoes_ibfk_2` FOREIGN KEY (`tipo_devolucao_id`) REFERENCES `tipo_devolucao` (`id`),
  ADD CONSTRAINT `devolucoes_ibfk_3` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `devolucoes_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `status_devolucao` (`id`),
  ADD CONSTRAINT `devolucoes_ibfk_5` FOREIGN KEY (`usuario_responsavel`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Constraints for table `historico_comissoes`
--
ALTER TABLE `historico_comissoes`
  ADD CONSTRAINT `historico_comissoes_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `historico_comissoes_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `historico_comissoes_ibfk_3` FOREIGN KEY (`tipo_comissao_id`) REFERENCES `tipos_comissao` (`id`),
  ADD CONSTRAINT `historico_comissoes_ibfk_4` FOREIGN KEY (`tipo_movimentacao_id`) REFERENCES `tipo_movimentacao_comissao` (`id`),
  ADD CONSTRAINT `historico_comissoes_ibfk_5` FOREIGN KEY (`usuario_responsavel`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `historico_status_pedido`
--
ALTER TABLE `historico_status_pedido`
  ADD CONSTRAINT `historico_status_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `historico_status_pedido_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_pedido` (`id`),
  ADD CONSTRAINT `historico_status_pedido_ibfk_3` FOREIGN KEY (`usuario_responsavel`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `itens_catalogo`
--
ALTER TABLE `itens_catalogo`
  ADD CONSTRAINT `itens_catalogo_ibfk_1` FOREIGN KEY (`catalogo_id`) REFERENCES `catalogos` (`id`),
  ADD CONSTRAINT `itens_catalogo_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `itens_catalogo_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status_item_catalogo` (`id`);

--
-- Constraints for table `itens_devolucao`
--
ALTER TABLE `itens_devolucao`
  ADD CONSTRAINT `itens_devolucao_ibfk_1` FOREIGN KEY (`item_pedido_id`) REFERENCES `itens_pedido` (`id`),
  ADD CONSTRAINT `itens_devolucao_ibfk_2` FOREIGN KEY (`devolucao_id`) REFERENCES `devolucoes` (`id`);

--
-- Constraints for table `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Constraints for table `itens_promocao`
--
ALTER TABLE `itens_promocao`
  ADD CONSTRAINT `itens_promocao_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `itens_promocao_ibfk_2` FOREIGN KEY (`promocao_id`) REFERENCES `promocoes` (`id`);

--
-- Constraints for table `itens_resgate`
--
ALTER TABLE `itens_resgate`
  ADD CONSTRAINT `itens_resgate_ibfk_1` FOREIGN KEY (`item_catalogo_id`) REFERENCES `itens_catalogo` (`id`),
  ADD CONSTRAINT `itens_resgate_ibfk_2` FOREIGN KEY (`resgate_id`) REFERENCES `resgates` (`id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `metas`
--
ALTER TABLE `metas`
  ADD CONSTRAINT `metas_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `metas_ibfk_2` FOREIGN KEY (`lider_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `metas_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status_meta` (`id`);

--
-- Constraints for table `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD CONSTRAINT `movimentacao_estoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `movimentacao_estoque_ibfk_2` FOREIGN KEY (`tipo_movimentacao_id`) REFERENCES `tipo_movimentacao_estoque` (`id`),
  ADD CONSTRAINT `movimentacao_estoque_ibfk_3` FOREIGN KEY (`usuario_responsavel`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `pagamentos_ibfk_2` FOREIGN KEY (`usuario_responsavel`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_produto` (`id`);

--
-- Constraints for table `promocoes`
--
ALTER TABLE `promocoes`
  ADD CONSTRAINT `promocoes_ibfk_1` FOREIGN KEY (`tipo_promocao_id`) REFERENCES `tipo_promocao` (`id`),
  ADD CONSTRAINT `promocoes_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_promocao` (`id`);

--
-- Constraints for table `qualificacao_profissional`
--
ALTER TABLE `qualificacao_profissional`
  ADD CONSTRAINT `qualificacao_profissional_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `resgates`
--
ALTER TABLE `resgates`
  ADD CONSTRAINT `resgates_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `resgates_ibfk_2` FOREIGN KEY (`catalogo_id`) REFERENCES `catalogos` (`id`),
  ADD CONSTRAINT `resgates_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `status_resgate` (`id`),
  ADD CONSTRAINT `resgates_ibfk_4` FOREIGN KEY (`usuario_responsavel`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `solicitacoes_saque`
--
ALTER TABLE `solicitacoes_saque`
  ADD CONSTRAINT `solicitacoes_saque_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `solicitacoes_saque_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_solicitacao_saque` (`id`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`consultora_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status_consultoras` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
