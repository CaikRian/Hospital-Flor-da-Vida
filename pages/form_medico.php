<?php
include('../assets/controller/db_conexao.php'); // Conectar ao banco de dados
session_start();
if (!isset($_SESSION['nome_usuario'])) {
    header("Location: ../Hospital-Flor-da-Vida/index.php");
    exit();
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $nome_completo = $_POST['nome_completo'];
    $crm = $_POST['crm'];
    $especialidade = $_POST['especialidade'];
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha_medico = $_POST['senha_medico'];
    $horario_atendimento = $_POST['horario_atendimento'];


    // Preparar a consulta SQL
    $sql = "INSERT INTO medicos (nome_completo, crm, especialidade, genero, telefone, email, senha_medico, horario_atendimento) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparando a declaração
    if ($stmt = $conn->prepare($sql)) {
        // Ligando os parâmetros
        $stmt->bind_param('ssssssss', $nome_completo, $crm, $especialidade, $genero, $telefone, $email, $senha_medico, $horario_atendimento);

        // Executando a declaração
        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao realizar o cadastro: " . $stmt->error;
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" type="image/x-icon">
    <title>Hospital Flor da Vida - Cadastro de Médicos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Link do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Menu do Site Médico-->
    <nav class="navbar navbar-expand-lg navbar-light fs-6 pe-5 fixed-top color">
        <a class="navbar-brand ms-4 me-5" href="#">
            <img src="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" alt="Hospital Flor da Vida" class="img-fluid" width="70">
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex justify-content-between w-100">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCadastro" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pacientes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCadastro">
                        <li><a class="dropdown-item" href="./form_paciente.php">Novo Cadastro</a></li>
                        <li><a class="dropdown-item" href="./consultar_pacientes.php">Consultar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAgendamentos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Médicos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownAgendamentos">
                        <li><a class="dropdown-item" href="./form_medico.php">Novo Cadastro</a></li>
                        <li><a class="dropdown-item" href="./consultar_medicos.php">Consultar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownExames" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Consultas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownExames">
                        <li><a class="dropdown-item" href="form_exame.php">Solicitar</a></li>
                        <li><a class="dropdown-item" href="consultar_exames.php">Registros</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPerfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Meu Perfil
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownPerfil">
                        <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Configurações</a></li>
                        <li><a class="dropdown-item" href="#">Suporte</a></li>
                        <li><a class="dropdown-item" href="../index.php">Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Container do formulário -->
    <div class="container mt-5" id="custom_container">
        <h2 class="mb-5 text-center">Cadastro Médico</h2>
        
        <form action="" method="POST">
            <!-- Nome Completo -->
            <div class="mb-3">
                <label for="nome_completo" class="form-label">* Nome Completo</label>
                <input type="text" class="form-control" id="nome_completo" name="nome_completo" required>
            </div>

            <!-- CRM -->
            <div class="mb-3">
                <label for="crm" class="form-label">* CRM</label>
                <input type="text" class="form-control" id="crm" name="crm" placeholder="Digite o número do CRM" required>
            </div>

            <!-- Especialidade -->
            <div class="mb-3">
                <label for="especialidade" class="form-label">* Especialidade</label>
                <input type="text" class="form-control" id="especialidade" name="especialidade" placeholder="Digite a especialidade médica" required>
            </div>

            <!-- Gênero -->
            <div class="mb-3">
                <label for="genero" class="form-label">* Gênero</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="" disabled selected>Selecione seu gênero</option>
                    <option value="mulher_cis">Mulher Cisgênero</option>
                    <option value="homem_cis">Homem Cisgênero</option>
                    <option value="mulher_trans">Mulher Transgênero</option>
                    <option value="homem_trans">Homem Transgênero</option>
                    <option value="não_binário">Não-binário</option>
                    <option value="outro">Outro</option>
                    <option value="prefiro_nao_informar">Prefiro não informar</option>
                </select>
            </div>

            <!-- Contato -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="telefone" class="form-label">* Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite seu telefone" maxlength="15" required>
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">* E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
                <div class="col-md-4">
                    <label for="senha" class="form-label">* Senha</label>
                    <input type="password" class="form-control" id="senha_medico" name="senha_medico" placeholder="Digite sua senha" required>
                </div>
            </div>
            
            <!-- Horário de Atendimento -->
            <div class="mb-3">
                <label for="horario_atendimento" class="form-label">* Horário de Atendimento</label>
                <input type="text" class="form-control" id="horario_atendimento" name="horario_atendimento" placeholder="Ex: Segunda a Sexta, das 8h às 18h" required>
            </div>

            <!-- Botões -->
            <button type="submit" class="btn custom-btn mb-5 p-3" id="btn-submit">ENVIAR</button>
            <button type="reset" class="btn btn-secondary mb-5 p-3">LIMPAR</button>
            
        </form>
    </div>

    <!-- Rodapé da página -->
    <footer class="bg-light text-dark mt-5">
        <div class="container py-4">
            <!-- Logo do Hospital -->
            <div class="row justify-content-center mb-4">
                <div class="w-100 col-md-3 mb-5 text-center ">
                    <img src="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" alt="Logo do Hospital Flor da Vida" class="img-fluid" style="max-width: 200px;">
                    <h1>  Hospital Flor da Vida </h1>
                </div>
            </div>
    
            <div class="row g-4">
                <!-- Links Úteis -->
                <div class="col-md-4">
                    <h5 class="fw-bold">Links Úteis</h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.php">Início</a></li>
                        <li><a href="../pacientes/form_paciente.php">Pacientes</a></li>
                        <li><a href="../agendamentos/consultar_agendamentos.php">Agendamentos</a></li>
                        <li><a href="../exames/form_exame.php">Exames</a></li>
                        <li><a href="#">Meu Perfil</a></li>
                    </ul>
                </div>
    
                <!-- Informações de Contato -->
                <div class="col-md-4">
                    <h5 class="fw-bold">Contato</h5>
                    <p>Email: <a href="mailto:suporte@flordavida.com.br">suporte@flordavida.com.br</a></p>
                    <p>Telefone: (11) 1234-5678</p>
                    <p>Endereço: Rua Flor da Vida, 123, Centro Médico, São Paulo - SP</p>
                    <p>Horário de Suporte: Segunda a Sexta, 8h - 18h</p>
                </div>
    
                <!-- Informações Legais -->
                <div class="col-md-4">
                    <h5 class="fw-bold">Informações Legais</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Política de Privacidade</a></li>
                        <li><a href="#">Termos de Uso</a></li>
                        <li><a href="#">Segurança de Dados</a></li>
                    </ul>
                </div>
            </div>
    
            <!-- Criação e Direitos -->
            <div class="row mt-4 align-items-center g-4">
                <div class="col-md-6">
                    <p>Site desenvolvido por <a href="https://meu-portfolio-pi-opal.vercel.app" target="_blank"><b>Caik Rian</b></a></p>
                    <p><a href="https://github.com/CaikRian" target="_blank"><b>Meu GitHub</b></a></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>© 2024 Hospital Flor da Vida. Todos os direitos reservados.</p>
                    <p><small>Este site é fictício e criado apenas para fins demonstrativos.</small></p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
