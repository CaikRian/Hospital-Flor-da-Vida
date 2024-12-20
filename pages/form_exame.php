<?php
session_start();
include('../assets/controller/db_conexao.php'); // Conectar com o banco de dados

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Consultar todos os médicos e pacientes para exibição nos campos de seleção
$sql_pacientes = "SELECT id, nome_completo FROM pacientes";
$sql_medicos = "SELECT id, nome_completo FROM medicos";
$pacientes_result = $conn->query($sql_pacientes);
$medicos_result = $conn->query($sql_medicos);

// Enviar solicitação de consulta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['solicitar'])) {
    $data_consulta = $_POST['data_consulta'];
    $horario_consulta = $_POST['horario_consulta'];
    $motivo_consulta = $_POST['motivo_consulta'];
    $observacoes = $_POST['observacoes'];
    $status = 'agendada'; // Definir status como 'agendada' por padrão
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];

    $sql_solicitar = "
        INSERT INTO consultas (data_consulta, horario_consulta, motivo_consulta, observacoes, status, id_paciente, id_medico)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";
    $stmt_solicitar = $conn->prepare($sql_solicitar);
    $stmt_solicitar->bind_param("sssssii", $data_consulta, $horario_consulta, $motivo_consulta, $observacoes, $status, $id_paciente, $id_medico);

    if ($stmt_solicitar->execute()) {
        // Mensagem de sucesso
        $mensagem_sucesso = "Consulta solicitada com sucesso!";
    } else {
        // Mensagem de erro
        $mensagem_erro = "Erro ao solicitar a consulta. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Flor da Vida - Solicitar Consulta</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Menu do Site -->
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

<!-- Conteúdo Geral -->
<div class="container mt-5 pt-5" id="custom_container">
    <h2 class="mb-5 text-center">Solicitar Nova Consulta</h2>

    <?php if (isset($mensagem_erro)): ?>
        <div class="alert alert-danger text-center">
            <?php echo $mensagem_erro; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($mensagem_sucesso)): ?>
        <div class="alert alert-success text-center">
            <?php echo $mensagem_sucesso; ?>
        </div>
    <?php endif; ?>

    <form class="form_" action="" method="POST">

        <div class="row mb-3">
            <div class="col-12 col-md-6 col-lg-3">
                <label for="id_paciente" class="form-label">Paciente</label>
                <select name="id_paciente" class="form-control" required>
                    <?php while ($paciente = $pacientes_result->fetch_assoc()): ?>
                        <option value="<?php echo $paciente['id']; ?>">
                            <?php echo htmlspecialchars($paciente['nome_completo']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <label for="id_medico" class="form-label">Médico</label>
                <select name="id_medico" class="form-control" required>
                    <?php while ($medico = $medicos_result->fetch_assoc()): ?>
                        <option value="<?php echo $medico['id']; ?>">
                            <?php echo htmlspecialchars($medico['nome_completo']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <label for="data_consulta" class="form-label">Data da Consulta</label>
                <input type="date" name="data_consulta" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <label for="horario_consulta" class="form-label">Horário da Consulta</label>
                <input type="time" name="horario_consulta" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label for="motivo_consulta" class="form-label">Motivo da Consulta</label>
                <textarea name="motivo_consulta" class="form-control" rows="3" required></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label for="observacoes" class="form-label">Observações</label>
                <textarea name="observacoes" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" name="solicitar" class="btn btn-primary">Solicitar Consulta</button>
            <a href="consultar_exames.php" class="btn btn-secondary">Voltar</a>
        </div>
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
            <div class="col-md-4">
                <h5 class="fw-bold">Contato</h5>
                <p>Email: <a href="mailto:suporte@flordavida.com.br">suporte@flordavida.com.br</a></p>
                <p>Telefone: (11) 1234-5678</p>
                <p>Endereço: Rua Flor da Vida, 123, Centro Médico, São Paulo - SP</p>
                <p>Horário de Suporte: Segunda a Sexta, 8h - 18h</p>
            </div>
            <div class="col-md-4">
                <h5 class="fw-bold">Informações Legais</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Política de Privacidade</a></li>
                    <li><a href="#">Termos de Uso</a></li>
                    <li><a href="#">Segurança de Dados</a></li>
                </ul>
            </div>
        </div>
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
