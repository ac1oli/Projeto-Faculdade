-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/04/2025 às 02:42
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `nutrisync`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `consulta`
--

CREATE TABLE `consulta` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `status` enum('agendado','cancelado','realizada') DEFAULT 'agendado',
  `hora` time NOT NULL,
  `usuario_fk` varchar(15) DEFAULT NULL,
  `nutricionista_fk` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `consulta`
--

INSERT INTO `consulta` (`id`, `data`, `status`, `hora`, `usuario_fk`, `nutricionista_fk`) VALUES
(1, '2025-04-18', 'agendado', '07:19:00', NULL, NULL),
(2, '2025-04-13', 'agendado', '15:25:00', '', NULL),
(3, '2025-04-13', 'agendado', '22:34:00', '', NULL),
(4, '2025-04-13', 'agendado', '22:34:00', '', NULL),
(5, '2025-04-13', 'agendado', '22:34:00', '', NULL),
(6, '2025-04-13', 'agendado', '16:39:00', '14107165469', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nutricionista`
--

CREATE TABLE `nutricionista` (
  `crn` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(10) NOT NULL,
  `telefone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `cpf` varchar(20) NOT NULL,
  `data_nasc` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sexo` enum('F','M') NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `idade` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`cpf`, `data_nasc`, `email`, `nome`, `sexo`, `telefone`, `senha`, `idade`) VALUES
('12345678901', '2006-05-12', 'selena@gmail.com', 'Selena', 'F', '81993997730', '$2y$10$FzH7sIn/', 18),
('12345678909', '2006-05-12', 'selenamenezes@gmail.com', 'Selena Menezes', 'F', '81993997730', '$2y$10$ee0QMZTy', 18),
('14107165469', '2002-08-11', 'joseprignolato@gmail.com', 'José Pedro Alves Da Silva Prignolato', 'M', '81994099330', '$2y$10$flb1n2IX3E7vDKmN9nY33OvJWKCSFkBSIxwG8SBjPm3gwC1INsZ9G', 22),
('28794303400', '2003-08-11', 'joao@gmail.com', 'João Marcos', 'M', '81994099330', '$2y$10$H8LVqJ3Y3Ya.54wT6rzmq.i4UInrff5kPSvUnVuG7mPLlkDo7hB2u', 21);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_fk` (`usuario_fk`),
  ADD KEY `nutricionista_fk` (`nutricionista_fk`);

--
-- Índices de tabela `nutricionista`
--
ALTER TABLE `nutricionista`
  ADD PRIMARY KEY (`crn`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
