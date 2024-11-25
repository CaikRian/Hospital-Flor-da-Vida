-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Nov-2024 às 02:54
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hospitalflordavida`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nome_admin` varchar(100) DEFAULT NULL,
  `senha_admin` varchar(255) DEFAULT NULL,
  `email_admin` varchar(100) DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `administradores`
--

INSERT INTO `administradores` (`id`, `nome_admin`, `senha_admin`, `email_admin`, `data_registro`) VALUES
(1, 'admin', '123', 'admin@email.com', '2024-11-24 21:21:52'),
(2, 'Carlos Silva', '*D5CCF4F4E3A6A9C47D673D8BB1E04717CEB01AE1', 'carlos.silva@flordavida.com.br', '2024-11-25 01:11:59'),
(3, 'Maria Oliveira', '*1CC598930099C0E650269AEC2F46406587D85AE3', 'maria.oliveira@flordavida.com.br', '2024-11-25 01:11:59'),
(4, 'João Pereira', '*899DDD800B2902A7F28E81A454486108E2B35F3D', 'joao.pereira@flordavida.com.br', '2024-11-25 01:11:59'),
(5, 'Ana Souza', '*A87CB4A128E26A8300859EB5841F1C2B5903CF44', 'ana.souza@flordavida.com.br', '2024-11-25 01:11:59'),
(6, 'Roberto Lima', '*4EB00419A37DD4D5A7A883A1E65AD8257EDD6114', 'roberto.lima@flordavida.com.br', '2024-11-25 01:11:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `horario_consulta` time NOT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('Agendada','Realizada','Cancelada') DEFAULT 'Agendada',
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `consultas`
--

INSERT INTO `consultas` (`id_consulta`, `id_paciente`, `id_medico`, `data_consulta`, `horario_consulta`, `motivo_consulta`, `observacoes`, `status`, `data_registro`) VALUES
(1, 173, 1, '2024-11-25', '09:00:00', 'Consulta de rotina', 'Sem queixas no momento', '', '2024-11-25 01:36:19'),
(2, 173, 2, '2024-12-02', '14:00:00', 'Avaliação de alergia', 'Sintomas de alergia a pólen', '', '2024-11-25 01:36:19'),
(3, 173, 3, '2024-12-10', '11:00:00', 'Dor nas articulações', 'Queixa de dores nos joelhos', '', '2024-11-25 01:36:19'),
(4, 174, 2, '2024-11-26', '10:00:00', 'Exame de pele', 'Aparecimento de manchas na pele', '', '2024-11-25 01:36:19'),
(5, 175, 4, '2024-11-27', '15:00:00', 'Acompanhamento de hipertensão', 'Pressão controlada com medicamentos', '', '2024-11-25 01:36:19'),
(6, 176, 5, '2024-11-28', '08:00:00', 'Consulta de rotina', 'Sem queixas de saúde', '', '2024-11-25 01:36:19'),
(7, 177, 6, '2024-11-29', '13:00:00', 'Acompanhamento de enxaqueca', 'Enxaquecas frequentes', '', '2024-11-25 01:36:19'),
(8, 178, 7, '2024-12-01', '10:00:00', 'Consulta de rotina', 'Sem queixas de saúde', '', '2024-11-25 01:36:19'),
(9, 179, 1, '2024-12-03', '14:00:00', 'Acompanhamento de colesterol', 'Colesterol controlado', '', '2024-11-25 01:36:19'),
(10, 180, 2, '2024-12-04', '09:00:00', 'Consulta ginecológica', 'Exame preventivo', '', '2024-11-25 01:36:19'),
(11, 181, 3, '2024-12-05', '11:00:00', 'Dor nas costas', 'Dores na coluna lombar', '', '2024-11-25 01:36:19'),
(12, 182, 4, '2024-12-06', '16:00:00', 'Fratura no braço', 'Paciente com fratura recente', '', '2024-11-25 01:36:19'),
(13, 183, 5, '2024-12-07', '09:00:00', 'Consulta pediátrica', 'Acompanhamento de crescimento', '', '2024-11-25 01:36:19'),
(14, 184, 6, '2024-12-08', '13:00:00', 'Acompanhamento psicológico', 'Paciente com sintomas de ansiedade', '', '2024-11-25 01:36:19'),
(15, 185, 7, '2024-12-09', '10:00:00', 'Consulta de rotina', 'Sem queixas de saúde', '', '2024-11-25 01:36:19'),
(16, 186, 1, '2024-12-11', '08:00:00', 'Consulta cardiológica', 'Dor no peito', '', '2024-11-25 01:36:19'),
(17, 187, 2, '2024-12-12', '15:00:00', 'Exame dermatológico', 'Manchas e irritações na pele', '', '2024-11-25 01:36:19'),
(18, 188, 3, '2024-12-13', '09:00:00', 'Dor nas articulações', 'Paciente com dor no quadril', '', '2024-11-25 01:36:19'),
(19, 189, 4, '2024-12-14', '11:00:00', 'Acompanhamento ortopédico', 'Fratura no braço em recuperação', '', '2024-11-25 01:36:19'),
(20, 190, 5, '2024-12-15', '14:00:00', 'Exame de controle da tireoide', 'Hipotireoidismo controlado', 'Cancelada', '2024-11-25 01:36:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `crm` varchar(20) NOT NULL,
  `especialidade` varchar(100) NOT NULL,
  `genero` enum('mulher_cis','homem_cis','mulher_trans','homem_trans','não_binário','outro','prefiro_nao_informar') NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `horario_atendimento` varchar(255) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `senha_medico` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `medicos`
--

INSERT INTO `medicos` (`id`, `nome_completo`, `crm`, `especialidade`, `genero`, `telefone`, `email`, `horario_atendimento`, `data_registro`, `senha_medico`) VALUES
(1, 'Caik', '123', 'Dermatologista', '', '11937070068', 'caikvieiragadelha@gmail.com', 'não trabalha', '2024-11-25 00:54:11', '234'),
(2, 'Dr. João Martins', '123456-SP', 'Cardiologia', 'homem_cis', '(11) 98765-4321', 'joao.martins@medico.com.br', 'Segunda a Sexta, 09:00 - 17:00', '2024-11-25 01:29:30', 'senha123'),
(3, 'Dra. Maria Oliveira', '234567-RJ', 'Dermatologia', 'mulher_cis', '(21) 97654-3210', 'maria.oliveira@medico.com.br', 'Segunda a Quinta, 10:00 - 16:00', '2024-11-25 01:29:30', 'senha456'),
(4, 'Dr. Roberto Costa', '345678-MG', 'Ortopedia', 'homem_cis', '(31) 96543-2109', 'roberto.costa@medico.com.br', 'Segunda a Sexta, 08:00 - 18:00', '2024-11-25 01:29:30', 'senha789'),
(5, 'Dra. Juliana Souza', '456789-PR', 'Ginecologia', 'mulher_cis', '(41) 95432-1098', 'juliana.souza@medico.com.br', 'Terça e Quinta, 08:00 - 14:00', '2024-11-25 01:29:30', 'senha101112'),
(6, 'Dr. Felipe Almeida', '567890-BA', 'Pediatria', 'homem_cis', '(71) 94321-0987', 'felipe.almeida@medico.com.br', 'Segunda a Sexta, 10:00 - 16:00', '2024-11-25 01:29:30', 'senha131415'),
(7, 'Dra. Cláudia Rodrigues', '678901-CE', 'Neurologia', 'mulher_cis', '(85) 93210-9876', 'claudia.rodrigues@medico.com.br', 'Segunda, Quarta e Sexta, 09:00 - 17:00', '2024-11-25 01:29:30', 'senha161718'),
(8, 'Dr. Marcos Pereira', '789012-SC', 'Oftalmologia', 'homem_cis', '(48) 92109-8765', 'marcos.pereira@medico.com.br', 'Segunda a Sexta, 07:00 - 15:00', '2024-11-25 01:29:30', 'senha192021');

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumo` text NOT NULL,
  `data_publicacao` datetime NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `status` enum('ativa','inativa') DEFAULT 'ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `resumo`, `data_publicacao`, `imagem`, `status`) VALUES
(1, 'Hospital Flor da Vida Recebe Certificação de Qualidade', 'O Hospital Flor da Vida recebeu hoje a certificação de qualidade, reconhecendo seu comprometimento com a excelência no atendimento.', '2024-11-23 08:00:00', 'certificacao_qualidade.jpg', 'ativa'),
(2, 'Nova Unidade de Terapia Intensiva (UTI) Inaugurada', 'Foi inaugurada hoje a nova UTI do Hospital Flor da Vida, equipada com tecnologia de ponta e mais leitos para os pacientes críticos.', '2024-11-21 10:30:00', 'uti_inauguracao.jpg', 'ativa'),
(3, 'Campanha de Prevenção ao Câncer de Mama', 'O hospital iniciou uma campanha de conscientização e prevenção ao câncer de mama, com exames gratuitos durante o mês de outubro.', '2024-10-15 15:00:00', 'campanha_cancer_mama.jpg', 'ativa'),
(4, 'Pesquisa sobre Doenças Cardíacas Tem Sucesso', 'Uma pesquisa conduzida pelo Hospital Flor da Vida sobre doenças cardíacas foi premiada em um congresso internacional.', '2024-10-05 12:00:00', 'pesquisa_cardiaca.jpg', 'ativa'),
(5, 'Atendimento Especializado em Pediatria', 'O Hospital Flor da Vida agora oferece atendimento especializado em pediatria, com profissionais renomados para cuidar das crianças.', '2024-09-30 09:00:00', 'pediatria_atendimento.jpg', 'ativa'),
(6, 'Hospital Realiza Mutirão de Cirurgias', 'O Hospital Flor da Vida realizou um mutirão de cirurgias para atender pacientes que aguardavam por procedimentos médicos.', '2024-09-20 16:00:00', 'mutirao_cirurgias.jpg', 'ativa'),
(7, 'Semana de Conscientização sobre Diabetes', 'Durante a semana, o Hospital Flor da Vida promoveu uma série de atividades educativas sobre prevenção e controle do diabetes.', '2024-09-10 11:00:00', 'conscientizacao_diabetes.jpg', 'ativa'),
(8, 'Hospital Recebe Novo Equipamento de Ressonância Magnética', 'O Hospital Flor da Vida adquiriu um novo aparelho de ressonância magnética, oferecendo exames mais rápidos e precisos.', '2024-08-30 14:30:00', 'ressonancia_magnetica.jpg', 'ativa'),
(9, 'Programa de Acompanhamento Pós-Cirúrgico Inicia', 'Foi lançado um novo programa para acompanhamento de pacientes pós-cirúrgicos, oferecendo suporte e cuidados contínuos.', '2024-08-10 13:30:00', 'acompanhamento_pos_cirurgico.jpg', 'ativa'),
(10, 'Semana de Vacinação Contra a Covid-19', 'O hospital promoveu uma semana de vacinação contra a Covid-19, oferecendo doses para a população e para os profissionais de saúde.', '2024-07-20 17:00:00', 'vacina_covid.jpg', 'ativa'),
(11, 'Hospitais Filantrópicos Recebem Ajuda do Governo', 'O governo anunciou um pacote de ajuda para hospitais filantrópicos, incluindo o Hospital Flor da Vida, para melhorar a infraestrutura e o atendimento.', '2024-07-05 10:15:00', 'ajuda_governo.jpg', 'ativa'),
(12, 'Novo Aumento na Capacidade de Atendimento do Pronto-Socorro', 'O pronto-socorro do Hospital Flor da Vida aumentou sua capacidade de atendimento, com mais leitos e equipes médicas disponíveis 24h.', '2024-06-25 18:00:00', 'pronto_socorro.jpg', 'ativa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` enum('mulher_cis','homem_cis','mulher_trans','homem_trans','não_binário','outro','prefiro_nao_informar') NOT NULL,
  `cpf` char(14) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `historico_medico` text DEFAULT NULL,
  `mensagem` text NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `senha_paciente` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome_completo`, `data_nascimento`, `genero`, `cpf`, `telefone`, `email`, `historico_medico`, `mensagem`, `data_registro`, `senha_paciente`) VALUES
(173, 'Ana Clara Silva', '1995-07-20', 'mulher_cis', '123.456.789-00', '(11) 98765-4321', 'ana.silva@flordavida.com.br', 'Histórico de alergias a medicamentos.', 'Gostaria de um atendimento para consulta geral.', '2024-11-25 01:25:15', 'senha123'),
(174, 'Carlos Eduardo Oliveira', '1982-03-15', 'homem_cis', '234.567.890-01', '(11) 97654-3210', 'carlos.oliveira@flordavida.com.br', 'Nenhum histórico médico relevante.', 'Solicito uma consulta para check-up geral.', '2024-11-25 01:25:15', 'senha456'),
(175, 'Felipe Souza', '1998-02-05', 'homem_cis', '345.678.901-02', '(11) 94321-0987', 'felipe.souza@flordavida.com.br', 'Hipertensão controlada com medicamentos.', 'Atendimento para avaliação de pressão arterial.', '2024-11-25 01:25:15', 'senha101'),
(176, 'Mariana Costa', '1985-09-25', 'mulher_cis', '456.789.012-03', '(11) 93210-9876', 'mariana.costa@flordavida.com.br', 'Histórico de cirurgia no joelho.', 'Gostaria de consulta para dor nas articulações.', '2024-11-25 01:25:15', 'senha102'),
(177, 'João Silva', '1993-06-17', 'homem_cis', '567.890.123-04', '(11) 92109-8765', 'joao.silva@flordavida.com.br', 'Nenhum histórico médico relevante.', 'Atendimento para dor no peito.', '2024-11-25 01:25:15', 'senha103'),
(178, 'Patrícia Lima', '1975-12-30', 'mulher_cis', '678.901.234-05', '(11) 91098-7654', 'patricia.lima@flordavida.com.br', 'Asma leve, usa inalador.', 'Consulta para acompanhamento da asma.', '2024-11-25 01:25:15', 'senha104'),
(179, 'Roberto Rocha', '1980-08-22', 'homem_cis', '789.012.345-06', '(11) 89876-5432', 'roberto.rocha@flordavida.com.br', 'Histórico de colesterol alto.', 'Consulta para verificar colesterol e triglicerídeos.', '2024-11-25 01:25:15', 'senha105'),
(180, 'Cláudia Almeida', '1996-04-11', 'mulher_cis', '890.123.456-07', '(11) 88765-4321', 'claudia.almeida@flordavida.com.br', 'Não possui doenças crônicas.', 'Solicito uma consulta de rotina.', '2024-11-25 01:25:15', 'senha106'),
(181, 'Marcos Santos', '1983-01-02', 'homem_cis', '901.234.567-08', '(11) 87654-3210', 'marcos.santos@flordavida.com.br', 'Faz uso de medicação para ansiedade.', 'Consulta para acompanhamento de saúde mental.', '2024-11-25 01:25:15', 'senha107'),
(182, 'Juliana Ferreira', '1991-10-30', 'mulher_cis', '012.345.678-09', '(11) 86543-2109', 'juliana.ferreira@flordavida.com.br', 'Histórico de pressão alta controlada.', 'Consulta para avaliação de pressão e exames de rotina.', '2024-11-25 01:25:15', 'senha108'),
(183, 'Lucas Martins', '2000-02-27', 'homem_cis', '123.456.789-10', '(11) 85432-1098', 'lucas.martins@flordavida.com.br', 'Nenhum histórico médico relevante.', 'Gostaria de uma consulta para alergias.', '2024-11-25 01:25:15', 'senha109'),
(184, 'Luciana Rodrigues', '1994-05-18', 'mulher_cis', '234.567.890-11', '(11) 84321-0987', 'luciana.rodrigues@flordavida.com.br', 'Histórico de dores nas costas.', 'Consulta para avaliação da coluna e dor nas costas.', '2024-11-25 01:25:15', 'senha110'),
(185, 'Daniela Costa', '1988-07-10', 'mulher_cis', '345.678.901-12', '(11) 83210-9876', 'daniela.costa@flordavida.com.br', 'Histórico de depressão, em tratamento.', 'Gostaria de ajuda com controle da ansiedade.', '2024-11-25 01:25:15', 'senha111'),
(186, 'Vinícius Almeida', '1997-11-02', 'homem_cis', '456.789.012-13', '(11) 82109-8765', 'vinicius.almeida@flordavida.com.br', 'Nenhum histórico médico relevante.', 'Atendimento para avaliação de dores musculares.', '2024-11-25 01:25:15', 'senha112'),
(187, 'Beatriz Silva', '1989-03-19', 'mulher_cis', '567.890.123-14', '(11) 81098-7654', 'beatriz.silva@flordavida.com.br', 'Histórico de alergias alimentares.', 'Consulta para orientação sobre alergias alimentares.', '2024-11-25 01:25:15', 'senha113'),
(188, 'Thiago Pereira', '1992-01-07', 'homem_cis', '678.901.234-15', '(11) 79876-5432', 'thiago.pereira@flordavida.com.br', 'Alergia ao pólen.', 'Consulta para tratamento de alergias.', '2024-11-25 01:25:15', 'senha114'),
(189, 'Sofia Rodrigues', '2001-05-14', 'mulher_cis', '789.012.345-16', '(11) 78765-4321', 'sofia.rodrigues@flordavida.com.br', 'Histórico de enxaquecas frequentes.', 'Gostaria de um tratamento para enxaquecas.', '2024-11-25 01:25:15', 'senha115'),
(190, 'Felipe Oliveira', '1994-12-09', 'homem_cis', '890.123.456-17', '(11) 77654-3210', 'felipe.oliveira@flordavida.com.br', 'Hipotireoidismo controlado com medicamentos.', 'Atendimento para monitoramento da tireoide.', '2024-11-25 01:25:15', 'senha116'),
(191, 'Larissa Almeida', '1999-10-05', 'mulher_cis', '901.234.567-18', '(11) 76543-2109', 'larissa.almeida@flordavida.com.br', 'Histórico de problemas digestivos.', 'Consulta para exames e orientação alimentar.', '2024-11-25 01:25:15', 'senha117'),
(192, 'Bruno Costa', '1987-02-28', 'homem_cis', '012.345.678-19', '(11) 75432-1098', 'bruno.costa@flordavida.com.br', 'Faz uso de medicação para colesterol alto.', 'Gostaria de fazer exames de colesterol.', '2024-11-25 01:25:15', 'senha118');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Índices para tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crm` (`crm`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
