<?php
include('../assets/controller/db_conexao.php'); // Conectar ao banco de dados
session_start();
if (!isset($_SESSION['nome_usuario'])) {
    header("Location: ../Hospital-Flor-da-Vida/index.php");
    exit();
}

// Variáveis para mensagens
$mensagem_sucesso = "";
$erro = "";

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados do formulário
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha_paciente = $_POST['senha_paciente'];
    $historico_medico = $_POST['historico_medico'];
    $mensagem = $_POST['mensagem'];

    // Validar o CPF 
    if (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $cpf)) {
        $erro = "CPF inválido!";
    } else {
        try {
            // Preparar a query para inserir os dados no banco
            $sql = "INSERT INTO pacientes (nome_completo, data_nascimento, genero, cpf, telefone, email, senha_paciente, historico_medico, mensagem)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparar a execução da query
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssss", $nome, $data_nascimento, $genero, $cpf, $telefone, $email, $senha_paciente, $historico_medico, $mensagem);

            // Tentar executar a query
            if ($stmt->execute()) {
                // Mensagem de sucesso
                $mensagem_sucesso = "Cadastro realizado com sucesso!";
                // Limpar os campos após o cadastro
                $nome = $data_nascimento = $genero = $cpf = $telefone = $email = $senha_paciente = $historico_medico = $mensagem = "";
            } else {
                // Caso a query falhe, exibir mensagem de erro
                throw new Exception("Erro ao cadastrar paciente. Tente novamente mais tarde.");
            }
        } catch (mysqli_sql_exception $e) {
            // Se o erro for relacionado a um erro no banco de dados, como CPF duplicado, exibir mensagem
            if (strpos($e->getMessage(), "Duplicate entry") !== false) {
                $erro = "Este CPF já está cadastrado. Por favor, use outro CPF.";
            } else {
                // Qualquer outro erro relacionado ao banco de dados
                $erro = "Houve um erro ao realizar o cadastro. Por favor, tente novamente mais tarde.";
            }
        } catch (Exception $e) {
            // Captura erros genéricos, como problemas de validação
            $erro = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" type="image/x-icon">
    <title>Hospital Flor da Vida - Registro de Paciente</title>
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

    <!-- Formulário de Cadastro -->
    <div class="container mt-5" id="custom_container">
        <h2 class="mb-5 text-center">Registro de Paciente</h2>

        <!-- Exibir mensagens de erro ou sucesso -->
        <?php if ($mensagem_sucesso): ?>
            <div class="alert alert-success text-center">
                <?php echo $mensagem_sucesso; ?>
            </div>
        <?php endif; ?>

        <?php if ($erro): ?>
            <div class="alert alert-danger text-center">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Nome Completo -->
            <div class="mb-3">
                <label for="nome" class="form-label">* Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" required value="<?php echo isset($nome) ? $nome : ''; ?>">
            </div>

            <!-- Data de Nascimento e Gênero -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="data_nascimento" class="form-label">* Data de Nascimento</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" min="1900-01-01" required value="<?php echo isset($data_nascimento) ? $data_nascimento : ''; ?>">
                </div>
                <div class="col-md-6">
                    <label for="genero" class="form-label">* Gênero</label>
                    <select class="form-select" id="genero" name="genero" required>
                        <option value="mulher_cis" <?php echo isset($genero) && $genero == 'mulher_cis' ? 'selected' : ''; ?>>Mulher Cisgênero</option>
                        <option value="homem_cis" <?php echo isset($genero) && $genero == 'homem_cis' ? 'selected' : ''; ?>>Homem Cisgênero</option>
                        <option value="mulher_trans" <?php echo isset($genero) && $genero == 'mulher_trans' ? 'selected' : ''; ?>>Mulher Transgênero</option>
                        <option value="homem_trans" <?php echo isset($genero) && $genero == 'homem_trans' ? 'selected' : ''; ?>>Homem Transgênero</option>
                        <option value="não_binário" <?php echo isset($genero) && $genero == 'não_binário' ? 'selected' : ''; ?>>Não-binário</option>
                        <option value="outro" <?php echo isset($genero) && $genero == 'outro' ? 'selected' : ''; ?>>Outro</option>
                        <option value="prefiro_nao_informar" <?php echo isset($genero) && $genero == 'prefiro_nao_informar' ? 'selected' : ''; ?>>Prefiro não informar</option>
                    </select>
                </div>
            </div>

            <!-- CPF, Telefone, Email -->
            <div class="row mb-5">
                <div class="col-md-3">
                    <label for="cpf" class="form-label">* CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" required value="<?php echo isset($cpf) ? $cpf : ''; ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo isset($telefone) ? $telefone : ''; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                </div>
            </div>

            <!-- Senha e Histórico Médico -->
            <div class="mb-3">
                <label for="senha_paciente" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha_paciente" name="senha_paciente" value="<?php echo isset($senha_paciente) ? $senha_paciente : ''; ?>" required>
            </div>

            <div class="mb-3">
                <label for="historico_medico" class="form-label">Histórico Médico</label>
                <textarea class="form-control" id="historico_medico" name="historico_medico" rows="3"><?php echo isset($historico_medico) ? $historico_medico : ''; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea class="form-control" id="mensagem" name="mensagem" rows="3"><?php echo isset($mensagem) ? $mensagem : ''; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar Paciente</button>
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
