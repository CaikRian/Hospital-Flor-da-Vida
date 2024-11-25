<?php
session_start();
include('../assets/controller/db_conexao.php'); // Conectar com o banco de dados

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Verificar se o ID da consulta foi passado pela URL
if (!isset($_GET['id_consulta'])) {
    header("Location: consultar_consultas.php");
    exit();
}

$id_consulta = $_GET['id_consulta'];

// Consultar os dados da consulta com base no id_consulta
$sql = "
    SELECT 
        consultas.id_consulta, 
        consultas.data_consulta, 
        consultas.horario_consulta, 
        consultas.motivo_consulta, 
        consultas.observacoes, 
        consultas.status, 
        pacientes.nome_completo AS nome_paciente, 
        pacientes.cpf AS cpf_paciente,
        medicos.nome_completo AS nome_medico, 
        medicos.especialidade AS especialidade_medico,
        consultas.id_paciente,
        consultas.id_medico
    FROM 
        consultas
    INNER JOIN 
        pacientes ON consultas.id_paciente = pacientes.id
    INNER JOIN 
        medicos ON consultas.id_medico = medicos.id
    WHERE 
        consultas.id_consulta = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_consulta);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se a consulta existe
if ($result->num_rows == 0) {
    echo "Consulta não encontrada.";
    exit();
}

$consulta = $result->fetch_assoc();

// Consultar todos os médicos e pacientes para exibição nos campos de seleção
$sql_pacientes = "SELECT id, nome_completo FROM pacientes";
$sql_medicos = "SELECT id, nome_completo FROM medicos";
$pacientes_result = $conn->query($sql_pacientes);
$medicos_result = $conn->query($sql_medicos);

// Atualizar consulta
$mensagem_sucesso = '';
$mensagem_erro = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $data_consulta = $_POST['data_consulta'];
    $horario_consulta = $_POST['horario_consulta'];
    $motivo_consulta = $_POST['motivo_consulta'];
    $observacoes = $_POST['observacoes'];
    $status = $_POST['status'];
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];

    $sql_atualizar = "
        UPDATE consultas
        SET data_consulta = ?, horario_consulta = ?, motivo_consulta = ?, observacoes = ?, status = ?, id_paciente = ?, id_medico = ?
        WHERE id_consulta = ?
    ";
    $stmt_atualizar = $conn->prepare($sql_atualizar);
    $stmt_atualizar->bind_param("sssssiii", $data_consulta, $horario_consulta, $motivo_consulta, $observacoes, $status, $id_paciente, $id_medico, $id_consulta);

    if ($stmt_atualizar->execute()) {
        $mensagem_sucesso = "Consulta atualizada com sucesso!";
    } else {
        $mensagem_erro = "Erro ao atualizar a consulta. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Flor da Vida - Ver Consulta</title>
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

    <div class="container mt-5 pt-5" id="custom_container">
        <h2 class="mb-5 text-center">Detalhes da Consulta</h2>

        <!-- Mensagens de Sucesso ou Erro -->
        <?php if (!empty($mensagem_sucesso)): ?>
            <div class="alert alert-success text-center">
                <?php echo $mensagem_sucesso; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($mensagem_erro)): ?>
            <div class="alert alert-danger text-center">
                <?php echo $mensagem_erro; ?>
            </div>
        <?php endif; ?>

        <!-- Formulário para edição da consulta -->
        <form action="" method="POST">
            <div class="row mb-3">
                <label for="data_consulta" class="col-sm-4 col-form-label">Data da Consulta</label>
                <div class="col-sm-8">
                    <input type="date" name="data_consulta" class="form-control" value="<?php echo htmlspecialchars($consulta['data_consulta']); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="horario_consulta" class="col-sm-4 col-form-label">Horário da Consulta</label>
                <div class="col-sm-8">
                    <input type="time" name="horario_consulta" class="form-control" value="<?php echo htmlspecialchars($consulta['horario_consulta']); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="motivo_consulta" class="col-sm-4 col-form-label">Motivo da Consulta</label>
                <div class="col-sm-8">
                    <textarea name="motivo_consulta" class="form-control" rows="4" required><?php echo htmlspecialchars($consulta['motivo_consulta']); ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="observacoes" class="col-sm-4 col-form-label">Observações</label>
                <div class="col-sm-8">
                    <textarea name="observacoes" class="form-control" rows="4"><?php echo htmlspecialchars($consulta['observacoes']); ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="status" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                    <select name="status" class="form-control" required>
                        <option value="Agendada" <?php echo $consulta['status'] == 'Agendada' ? 'selected' : ''; ?>>Agendada</option>
                        <option value="Concluída" <?php echo $consulta['status'] == 'Concluída' ? 'selected' : ''; ?>>Concluída</option>
                        <option value="Cancelada" <?php echo $consulta['status'] == 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="id_paciente" class="col-sm-4 col-form-label">Paciente</label>
                <div class="col-sm-8">
                    <select name="id_paciente" class="form-control" required>
                        <?php while ($paciente = $pacientes_result->fetch_assoc()): ?>
                            <option value="<?php echo $paciente['id']; ?>" <?php echo $paciente['id'] == $consulta['id_paciente'] ? 'selected' : ''; ?>>
                                <?php echo $paciente['nome_completo']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="id_medico" class="col-sm-4 col-form-label">Médico</label>
                <div class="col-sm-8">
                    <select name="id_medico" class="form-control" required>
                        <?php while ($medico = $medicos_result->fetch_assoc()): ?>
                            <option value="<?php echo $medico['id']; ?>" <?php echo $medico['id'] == $consulta['id_medico'] ? 'selected' : ''; ?>>
                                <?php echo $medico['nome_completo']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" name="atualizar" class="btn btn-primary">Atualizar Consulta</button>
                <a href="consultar_exames.php" class="btn btn-secondary">Voltar</a>
                
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
