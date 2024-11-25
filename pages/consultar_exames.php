<?php
session_start();
include('../assets/controller/db_conexao.php'); // Conectar com o banco de dados

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Verificar se foi enviado um ID para excluir a consulta
if (isset($_POST['id_consulta'])) {
    $id_consulta = $_POST['id_consulta'];
    
    // Verificar se o ID é válido (número)
    if (is_numeric($id_consulta)) {
        // Excluir a consulta do banco de dados
        $sql_delete = "DELETE FROM consultas WHERE id_consulta = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $id_consulta);
        
        if ($stmt->execute()) {
            // Sucesso na exclusão
            $_SESSION['mensagem_sucesso'] = "Consulta excluída com sucesso.";
        } else {
            // Erro na exclusão
            $_SESSION['mensagem_erro'] = "Erro ao excluir a consulta.";
        }
        $stmt->close();
    }
}

// Consultar todas as consultas registradas
$sql = "
    SELECT 
        consultas.id_consulta, 
        consultas.data_consulta, 
        consultas.horario_consulta, 
        pacientes.nome_completo AS nome_paciente, 
        pacientes.cpf AS cpf_paciente,
        medicos.nome_completo AS nome_medico, 
        medicos.especialidade AS especialidade_medico
    FROM 
        consultas
    INNER JOIN 
        pacientes ON consultas.id_paciente = pacientes.id
    INNER JOIN 
        medicos ON consultas.id_medico = medicos.id
    ORDER BY 
        consultas.data_consulta DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Flor da Vida - Consultas</title>
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

    <div class="container mt-5 pt-5 " id="custom_container">
        <h2 class="mb-5 text-center">Consultas Registradas</h2>

        <!-- Exibindo mensagens de sucesso ou erro -->
        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
            </div>
        <?php elseif (isset($_SESSION['mensagem_erro'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Protocolo</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Paciente</th>
                        <th>CPF do Paciente</th>
                        <th>Médico</th>
                        <th>Especialidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($consulta = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($consulta['id_consulta']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($consulta['data_consulta']))); ?></td>
                            <td><?php echo htmlspecialchars(date('H:i', strtotime($consulta['horario_consulta']))); ?></td>
                            <td><?php echo htmlspecialchars($consulta['nome_paciente']); ?></td>
                            <td><?php echo htmlspecialchars($consulta['cpf_paciente']); ?></td>
                            <td><?php echo htmlspecialchars($consulta['nome_medico']); ?></td>
                            <td><?php echo htmlspecialchars($consulta['especialidade_medico']); ?></td>
                            <td>
                                <!-- Botão "Ver Mais" -->
                                <a href="editar_exame.php?id_consulta=<?php echo $consulta['id_consulta']; ?>" class="btn btn-warning btn-sm">Ver Mais</a>

                                <!-- Formulário para excluir -->
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id_consulta" value="<?php echo $consulta['id_consulta']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta consulta?');">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Nenhuma consulta registrada no sistema.</p>
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
