<?php
session_start();
include('../assets/controller/db_conexao.php'); // Conectar com o banco de dados

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensagem_erro = "";
$mensagem_sucesso = "";

// Consultar todos os pacientes
$sql = "SELECT * FROM pacientes";
$result = $conn->query($sql);

// Atualizar dados do paciente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $cpf_paciente = $_POST['cpf'];
    $nome_completo = $_POST['nome_completo'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Atualizar os dados do paciente
    $sql_atualizar = "UPDATE pacientes SET nome_completo = ?, email = ?, telefone = ? WHERE cpf = ?";
    $stmt_atualizar = $conn->prepare($sql_atualizar);
    $stmt_atualizar->bind_param("ssss", $nome_completo, $email, $telefone, $cpf_paciente);

    if ($stmt_atualizar->execute()) {
        $mensagem_sucesso = "Dados atualizados com sucesso!";
    } else {
        $mensagem_erro = "Erro ao atualizar os dados. Tente novamente.";
    }
}

// Excluir paciente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir'])) {
    $cpf_paciente = $_POST['cpf_paciente'];

    // Verificar se o cpf foi passado corretamente
    if (empty($cpf_paciente)) {
        $mensagem_erro = "Erro: CPF do paciente não foi enviado.";
    } else {
        // Preparar a consulta para excluir o paciente
        $sql_excluir = "DELETE FROM pacientes WHERE cpf = ?";
        $stmt_excluir = $conn->prepare($sql_excluir);
        $stmt_excluir->bind_param("s", $cpf_paciente);

        if ($stmt_excluir->execute()) {
            $mensagem_sucesso = "Paciente excluído com sucesso!";
            // Redirecionar após exclusão para atualizar a lista
            header("Location: consultar_pacientes.php");
            exit();
        } else {
            $mensagem_erro = "Erro ao excluir paciente. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" type="image/x-icon">
    <title>Hospital Flor da Vida - Consultar Paciente</title>
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
        <h2 class="mb-5 text-center">Consultar Dados dos Pacientes</h2>

        <?php if ($mensagem_erro): ?>
            <div class="alert alert-danger text-center">
                <?php echo $mensagem_erro; ?>
            </div>
        <?php endif; ?>

        <?php if ($mensagem_sucesso): ?>
            <div class="alert alert-success text-center">
                <?php echo $mensagem_sucesso; ?>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Histórico</th>
                        <th>Detalhe</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($paciente = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($paciente['nome_completo']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['email']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['historico_medico']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['mensagem']); ?></td>
                            <td>
                                <a href="editar_paciente.php?cpf_paciente=<?php echo $paciente['cpf']; ?>" class="btn btn-warning">Ver Mais</a>

                                <!-- Formulário de exclusão -->
                                <form action="consultar_pacientes.php" method="POST" onsubmit="confirmarExclusao(event)">
                                    <input type="hidden" name="cpf_paciente" value="<?php echo htmlspecialchars($paciente['cpf']); ?>">
                                    <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Nenhum paciente encontrado. Por favor, adicione pacientes no sistema.</p>
        <?php endif; ?>
    </div>

    <footer class="bg-light text-center py-4 mt-5">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-md-3 mb-5 text-center">
                    <img src="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" alt="Logo do Hospital Flor da Vida" class="img-fluid" style="max-width: 200px;">
                    <h1>Hospital Flor da Vida</h1>
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
