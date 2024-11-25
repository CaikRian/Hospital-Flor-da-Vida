<?php
include('../assets/controller/db_conexao.php'); // Conectar com o banco de dados

// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['cpf'])) {
    header('Location: ../index.php'); // Redireciona para a página de login
    exit();
}

// Obtém o CPF do paciente da sessão
$cpf = $_SESSION['cpf'];

// Busca os dados do paciente
$sqlPaciente = "SELECT nome_completo, id FROM pacientes WHERE cpf = ?";
$stmtPaciente = $conn->prepare($sqlPaciente);
$stmtPaciente->bind_param("s", $cpf);
$stmtPaciente->execute();
$resultPaciente = $stmtPaciente->get_result();
$paciente = $resultPaciente->fetch_assoc();

if (!$paciente) {
    die("Paciente não encontrado.");
}

$pacienteId = $paciente['id'];

// Busca as consultas do paciente
$sqlConsultas = "
    SELECT consultas.data_consulta, consultas.horario_consulta, consultas.motivo_consulta, consultas.observacoes,
           medicos.nome_completo AS medico_nome, medicos.especialidade
    FROM consultas
    INNER JOIN medicos ON consultas.id_medico = medicos.id
    WHERE consultas.id_paciente = ?
    ORDER BY consultas.data_consulta ASC
";
$stmtConsultas = $conn->prepare($sqlConsultas);
$stmtConsultas->bind_param("i", $pacienteId);
$stmtConsultas->execute();
$resultConsultas = $stmtConsultas->get_result();
$consultas = $resultConsultas->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" type="image/x-icon">
    <title>Consultas - Hospital Flor da Vida</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light fs-6 pe-5 fixed-top color">
        <a class="navbar-brand ms-4 me-5" href="#">
            <img src="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" alt="Hospital Flor da Vida" class="img-fluid" width="70">
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex justify-content-between w-100">
                <li class="nav-item"><a class="nav-link" href="#">Minhas Consultas</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Notícias</a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php">Sair</a></li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo -->
    <div class="container mt-5 pt-5" id="custom_container">
        <div class="alert alert-primary text-center" role="alert">
            <h2>Bem-vindo, <?= htmlspecialchars($paciente['nome_completo']); ?>!</h2>
            <p>Confira suas consultas agendadas abaixo:</p>
        </div>

        <?php if (empty($consultas)): ?>
            <div class="alert alert-warning text-center">Você não possui consultas agendadas no momento.</div>
        <?php else: ?>
            <div class="row justify-content-center">
                <?php foreach ($consultas as $consulta): ?>
                    <div class="card m-3" style="max-width: 600px;">
                        <div class="card-header bg-primary text-white" style="border-radius: 0">
                            Consulta com <?= htmlspecialchars($consulta['medico_nome']); ?> (<?= htmlspecialchars($consulta['especialidade']); ?>)
                        </div>
                        <div class="card-body">
                        <p><strong>Data:</strong> <?= date("d/m/Y", strtotime($consulta['data_consulta'])); ?></p>
                            <p><strong>Horário:</strong> <?= htmlspecialchars($consulta['horario_consulta']); ?></p>
                            <p><strong>Motivo:</strong> <?= htmlspecialchars($consulta['motivo_consulta']); ?></p>
                            <p><strong>Observações:</strong> <?= htmlspecialchars($consulta['observacoes']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
                        <li><a href="#">Início</a></li>
                        <li><a href="#">Pacientes</a></li>
                        <li><a href="#">Agendamentos</a></li>
                        <li><a href="#">Exames</a></li>
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
