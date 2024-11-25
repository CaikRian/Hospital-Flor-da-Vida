<?php
session_start();
include('../assets/controller/db_conexao.php'); // Incluir a conexão com o banco de dados

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$mensagem_erro = "";
$mensagem_sucesso = "";
$paciente = null;

// Verificar se o ID do paciente foi passado via GET
if (isset($_GET['cpf_paciente'])) {
    $cpf_paciente = $_GET['cpf_paciente'];

    // Consultar os dados do paciente
    $sql = "SELECT * FROM pacientes WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $paciente = $result->fetch_assoc();
    } else {
        $mensagem_erro = "Paciente não encontrado.";
    }
}

// Atualizar os dados do paciente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $nome_completo = $_POST['nome_completo'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $historico_medico = $_POST['historico_medico'];
    $mensagem = $_POST['mensagem'];
    $senha_paciente = $_POST['senha_paciente'];

    // Atualizar os dados no banco
    $sql_atualizar = "UPDATE pacientes SET nome_completo = ?, data_nascimento = ?, genero = ?, telefone = ?, email = ?, historico_medico = ?, mensagem = ?, senha_paciente = ? WHERE cpf = ?";
    $stmt_atualizar = $conn->prepare($sql_atualizar);
    $stmt_atualizar->bind_param("sssssssss", $nome_completo, $data_nascimento, $genero, $telefone, $email, $historico_medico, $mensagem, $senha_paciente, $cpf_paciente);

    if ($stmt_atualizar->execute()) {
        $mensagem_sucesso = "Dados atualizados com sucesso!";
    } else {
        $mensagem_erro = "Erro ao atualizar os dados. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" type="image/x-icon">
    <title>Hospital Flor da Vida - Editar Paciente</title>
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
        <h2 class="mb-5 text-center">Editar Dados do Paciente</h2>
        
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

        <?php if ($paciente): ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nome_completo" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome_completo" name="nome_completo" value="<?php echo htmlspecialchars($paciente['nome_completo']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($paciente['data_nascimento']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="genero" class="form-label">Gênero</label>
                    <select class="form-select" id="genero" name="genero" required>
                        <option value="Masculino" <?php echo $paciente['genero'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Feminino" <?php echo $paciente['genero'] == 'Feminino' ? 'selected' : ''; ?>>Feminino</option>
                        <option value="Outro" <?php echo $paciente['genero'] == 'Outro' ? 'selected' : ''; ?>>Outro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($paciente['telefone']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($paciente['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="historico_medico" class="form-label">Histórico Médico</label>
                    <textarea class="form-control" id="historico_medico" name="historico_medico" rows="3" required><?php echo htmlspecialchars($paciente['historico_medico']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="mensagem" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" rows="3" required><?php echo htmlspecialchars($paciente['mensagem']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="senha_paciente" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha_paciente" name="senha_paciente" value="<?php echo htmlspecialchars($paciente['senha_paciente']); ?>" required>
                </div>
                
                <button type="submit" name="atualizar" class="btn btn-primary">Atualizar Dados</button>
                <a href="consultar_pacientes.php" class="btn btn-secondary">Voltar</a>
                
            </form>
        <?php else: ?>
            <p class="text-center">Paciente não encontrado. Por favor, verifique o CPF.</p>
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
