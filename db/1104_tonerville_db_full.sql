-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/11/2016 às 19:31
-- Versão do servidor: 5.7.11-log
-- Versão do PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tonerville_db`
--
CREATE DATABASE IF NOT EXISTS `tonerville_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tonerville_db`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `brands`
--

CREATE TABLE `brands` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID da marca.',
  `name` varchar(20) NOT NULL COMMENT 'Nome da marca.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo as marcas das impressoras.';

--
-- Fazendo dump de dados para tabela `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(01, 'HP'),
(02, 'Brother');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(1) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID da categoria de solicitação de serviço.',
  `name` varchar(45) NOT NULL COMMENT 'Nome da categoria de solicitação de serviço.',
  `priority` tinyint(1) UNSIGNED NOT NULL COMMENT 'Prioridade padrão da categoria de solicitação de serviço.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo as categorias de solicitação de serviço.';

--
-- Fazendo dump de dados para tabela `categories`
--

INSERT INTO `categories` (`id`, `name`, `priority`) VALUES
(1, 'Falta de tinta', 0),
(2, 'Defeito', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do cliente.',
  `users_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do usuário do cliente.',
  `cep` int(8) UNSIGNED ZEROFILL NOT NULL COMMENT 'CEP da residência onde as impressoras estão alugadas.',
  `rep_name` varchar(70) NOT NULL COMMENT 'Nome do representante da empresa cliente.',
  `city` varchar(40) NOT NULL COMMENT 'Cidade onde as impressoras estão alugadas.',
  `neighborhood` varchar(40) NOT NULL COMMENT 'Bairro onde as impressoras estão alugadas.',
  `street` varchar(100) NOT NULL COMMENT 'Rua onde as impressoras estão alugadas.',
  `street_num` int(5) UNSIGNED NOT NULL COMMENT 'Número da residência onde as impressoras estão alugadas.',
  `phone` bigint(11) UNSIGNED DEFAULT NULL COMMENT 'Telefone do cliente.',
  `street_comp` varchar(30) DEFAULT NULL COMMENT 'Complemento da residência onde as impressoras estão alugadas.',
  `cnpj` bigint(14) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'CNPJ do cliente.',
  `email` varchar(255) DEFAULT NULL COMMENT 'E-mail do cliente.',
  `ie` varchar(14) DEFAULT NULL COMMENT 'Inscrição estadual do cliente.',
  `trade_name` varchar(90) DEFAULT NULL COMMENT 'Nome fantasia do cliente.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo os clientes da empresa.';

--
-- Fazendo dump de dados para tabela `clients`
--

INSERT INTO `clients` (`id`, `users_id`, `cep`, `rep_name`, `city`, `neighborhood`, `street`, `street_num`, `phone`, `street_comp`, `cnpj`, `email`, `ie`, `trade_name`) VALUES
(0001, 0002, 32131312, 'Vinícius Zomer', 'Balneário Camboriu', 'Jamesca Framboesa', 'Rua Aldemar Valdemar', 2, 31294824909, 'Bloco A, sala 201', 87643406379732, 'vinicius@zomer.com', '36926432009548', 'Zomer Incorporated'),
(0002, 0003, 21898383, 'Vinícius Liberato Cidral Dallabona', 'Joinville', 'Floresta', 'Rua Presidente Dilma Rouseff', 96, 4788044408, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `employees`
--

CREATE TABLE `employees` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do funcionário.',
  `users_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do usuário do funcionário.',
  `name` varchar(70) NOT NULL COMMENT 'Nome completo do funcionário.',
  `phone` bigint(11) UNSIGNED DEFAULT NULL COMMENT 'Número de telefone do funcionário.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo os funcionários da empresa.';

--
-- Fazendo dump de dados para tabela `employees`
--

INSERT INTO `employees` (`id`, `users_id`, `name`, `phone`) VALUES
(03, 0009, 'Nicolas Yuri Gil', 1234567890);

-- --------------------------------------------------------

--
-- Estrutura para tabela `models`
--

CREATE TABLE `models` (
  `id` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do modelo.',
  `brands_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID da marca do modelo.',
  `name` varchar(60) NOT NULL COMMENT 'Nome do modelo.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo os modelos de impressoras.\n';

--
-- Fazendo dump de dados para tabela `models`
--

INSERT INTO `models` (`id`, `brands_id`, `name`) VALUES
(001, 02, 'HL-L3'),
(002, 01, 'Deskjet 550'),
(003, 01, 'Officejet 150');

-- --------------------------------------------------------

--
-- Estrutura para tabela `printers`
--

CREATE TABLE `printers` (
  `mlt` int(4) UNSIGNED NOT NULL COMMENT 'MLT da impressora.',
  `models_id` int(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do modelo da impressora.',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT 'Status da impressora.\n0 - disponível\n1 - alugada\n2 - retirada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo as impressoras da empresa.';

--
-- Fazendo dump de dados para tabela `printers`
--

INSERT INTO `printers` (`mlt`, `models_id`, `status`) VALUES
(4, 002, 0),
(23, 001, 0),
(44, 002, 0),
(152, 003, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `rentals`
--

CREATE TABLE `rentals` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do aluguel.',
  `clients_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do cliente que realizou o aluguel.',
  `page_distinction` tinyint(1) UNSIGNED ZEROFILL NOT NULL COMMENT 'Define se existe ou não distinção de preço entre páginas coloridas e monocromáticas. Se houver, a franquia e preço da franquia serão necessariamente 0.\n0 - Não há distinção.\n1 - Há distinção.',
  `bw_price` decimal(3,2) UNSIGNED NOT NULL COMMENT 'Preço da página preto em branco excedida.',
  `start_date` date NOT NULL COMMENT 'Data de início do aluguel.',
  `end_date` date NOT NULL COMMENT 'Data de término de aluguel.',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT 'Status do aluguel.\n0 - em andamento\n1 - relatório pedido\n2 - finalizado',
  `color_price` decimal(3,2) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Preço da página colorida excedida.',
  `page_cap` int(5) UNSIGNED DEFAULT NULL COMMENT 'Franquia de páginas do aluguel.',
  `page_cap_price` decimal(6,2) UNSIGNED DEFAULT NULL COMMENT 'Preço da franquia de páginas do aluguel.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo todos os aluguéis.';

-- --------------------------------------------------------

--
-- Estrutura para tabela `rentals_has_printers`
--

CREATE TABLE `rentals_has_printers` (
  `rentals_id` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do aluguel.',
  `printers_mlt` int(4) UNSIGNED NOT NULL COMMENT 'MLT da impressora.',
  `initial_total_meter` int(6) UNSIGNED NOT NULL COMMENT 'Medidor total inicial da impressora.',
  `initial_color_meter` int(6) UNSIGNED DEFAULT NULL COMMENT 'Medidor colorido inicial da impressora.',
  `final_total_meter` int(6) UNSIGNED DEFAULT NULL COMMENT 'Medidor total final da impressora.',
  `final_color_meter` int(6) UNSIGNED DEFAULT NULL COMMENT 'Medidor colorido final da impressora.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela detalhando quais impressoras estão em quais aluguéis, bem como informações adicionais sobre as impressoras.';

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitations`
--

CREATE TABLE `solicitations` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID da solicitação de serviço.',
  `categories_id` tinyint(1) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID da categoria da solicitação.',
  `printers_mlt` int(4) UNSIGNED NOT NULL COMMENT 'ID da impressora para qual foi solicitado o serviço.',
  `clients_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do cliente que fez a solicitação de serviço.',
  `users_id` int(4) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'ID do funcionário que se vinculará à solicitação.',
  `date` date NOT NULL COMMENT 'Data em que a solicitação de serviço foi feita.',
  `priority` tinyint(1) UNSIGNED NOT NULL COMMENT 'Prioridade da solicitação de serviço. Vai de 0 até 2.',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT 'Status da solicitação de serviço.\n0 - pendente\n1 - em andamento\n2 - realizada',
  `description` text COMMENT 'Descrição da solicitação de serviço.',
  `comment` text COMMENT 'Comentário feito após a finalização da solicitação de serviço.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela com as solicitações de serviço feitas pelos clientes.';

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do usuário.',
  `username` varchar(16) NOT NULL COMMENT 'Nome de usuário.',
  `password` char(32) NOT NULL COMMENT 'Senha do usuário.',
  `permission` tinyint(1) UNSIGNED NOT NULL COMMENT 'Permissão do usuário.\n0 - administrador\n1 - operacional\n2 - cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela com todos os usuários cadastrados.';

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `permission`) VALUES
(0001, 'adm', '3174a69bf36e5514a43efc6c6840ddda', 0),
(0002, 'zomer', '1fe27431d1800b345c0c6aeacdb25889', 2),
(0003, 'liberato', '9054c084646b9974bc7d59daf7f0878e', 2),
(0009, 'nicolas', '17c2bf70b309fa66cce896057584f523', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `videos`
--

CREATE TABLE `videos` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do vídeo.',
  `name` varchar(100) NOT NULL COMMENT 'Nome do vídeo.',
  `description` text NOT NULL COMMENT 'Descrição do vídeo.',
  `url` varchar(100) NOT NULL COMMENT 'URL do vídeo no YouTube.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela contendo os vídeos tutoriais para resolução de problemas de impressora.';

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_clients_users1_idx` (`users_id`);

--
-- Índices de tabela `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_employees_users_idx` (`users_id`);

--
-- Índices de tabela `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_models_brands1_idx` (`brands_id`);

--
-- Índices de tabela `printers`
--
ALTER TABLE `printers`
  ADD PRIMARY KEY (`mlt`),
  ADD KEY `fk_printers_models1_idx` (`models_id`);

--
-- Índices de tabela `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rentals_clients1_idx` (`clients_id`);

--
-- Índices de tabela `rentals_has_printers`
--
ALTER TABLE `rentals_has_printers`
  ADD PRIMARY KEY (`rentals_id`,`printers_mlt`),
  ADD KEY `fk_rentals_has_printers_printers1_idx` (`printers_mlt`),
  ADD KEY `fk_rentals_has_printers_rentals1_idx` (`rentals_id`);

--
-- Índices de tabela `solicitations`
--
ALTER TABLE `solicitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_solicitations_clients1_idx` (`clients_id`),
  ADD KEY `fk_solicitations_printers1_idx` (`printers_mlt`),
  ADD KEY `fk_solicitations_categories1_idx` (`categories_id`),
  ADD KEY `fk_solicitations_users1_idx` (`users_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `brands`
--
ALTER TABLE `brands`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID da marca.', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(1) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID da categoria de solicitação de serviço.', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do cliente.', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `employees`
--
ALTER TABLE `employees`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do funcionário.', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `models`
--
ALTER TABLE `models`
  MODIFY `id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do modelo.', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do aluguel.';
--
-- AUTO_INCREMENT de tabela `solicitations`
--
ALTER TABLE `solicitations`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID da solicitação de serviço.';
--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do usuário.', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de tabela `videos`
--
ALTER TABLE `videos`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do vídeo.';
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `fk_clients_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `fk_models_brands1` FOREIGN KEY (`brands_id`) REFERENCES `brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `printers`
--
ALTER TABLE `printers`
  ADD CONSTRAINT `fk_printers_models1` FOREIGN KEY (`models_id`) REFERENCES `models` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `fk_rentals_clients1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `rentals_has_printers`
--
ALTER TABLE `rentals_has_printers`
  ADD CONSTRAINT `fk_rentals_has_printers_printers1` FOREIGN KEY (`printers_mlt`) REFERENCES `printers` (`mlt`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rentals_has_printers_rentals1` FOREIGN KEY (`rentals_id`) REFERENCES `rentals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `solicitations`
--
ALTER TABLE `solicitations`
  ADD CONSTRAINT `fk_solicitations_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitations_clients1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitations_printers1` FOREIGN KEY (`printers_mlt`) REFERENCES `printers` (`mlt`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitations_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
