<?php
session_start();
include('./db_conexao.php');

// Variáveis para armazenar os dados do formulário
$nome_admin = $senha_admin = $cpf_paciente = $senha_paciente = $crm_medico = $senha_medico = "";

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cpf_paciente']) && isset($_POST['senha_paciente'])) {
        // Autenticar Paciente
        $cpf_paciente = $_POST['cpf_paciente'];
        $senha_paciente = $_POST['senha_paciente'];

        // Consulta ao banco de dados para verificar o paciente
        $sql_paciente = "SELECT nome_completo FROM pacientes WHERE cpf = ? AND senha_paciente = ?";
        $stmt_paciente = $conn->prepare($sql_paciente);
        $stmt_paciente->bind_param("ss", $cpf_paciente, $senha_paciente);
        $stmt_paciente->execute();
        $result_paciente = $stmt_paciente->get_result();

        if ($result_paciente->num_rows > 0) {
            // Recupera o cpf do paciente
            $row = $result_paciente->fetch_assoc();
            $_SESSION['cpf'] = $cpf_paciente;
            header("Location: http://localhost/Hospital-Flor-da-Vida/pages/saudacao_paciente.php"); // Página de saudação
            exit();
        } else {
            $_SESSION['erro_mensagem'] = "CPF ou senha inválidos. Tente novamente."; // Mensagem de erro
            header("Location: http://localhost/Hospital-Flor-da-Vida/index.php?login_error=true");
            exit();
        }

    } elseif (isset($_POST['crm_medico']) && isset($_POST['senha_medico'])) {
        // Autenticar Médico
        $crm_medico = $_POST['crm_medico'];
        $senha_medico = $_POST['senha_medico'];

        // Consulta ao banco de dados para verificar o médico
        $sql_medico = "SELECT nome_completo FROM medicos WHERE crm = ? AND senha_medico = ?";
        $stmt_medico = $conn->prepare($sql_medico);
        $stmt_medico->bind_param("ss", $crm_medico, $senha_medico);
        $stmt_medico->execute();
        $result_medico = $stmt_medico->get_result();

        if ($result_medico->num_rows > 0) {
            // Recupera o nome do médico
            $row = $result_medico->fetch_assoc();
            $_SESSION['nome_usuario'] = $row['nome_completo']; // Armazena o nome na sessão
            $_SESSION['usuario'] = $crm_medico;
            header("Location: http://localhost/Hospital-Flor-da-Vida/pages/saudacao_medico.php"); // Página de saudação
            exit();
        } else {
            $_SESSION['erro_mensagem'] = "CRM ou senha inválidos. Tente novamente."; // Mensagem de erro
            header("Location: http://localhost/Hospital-Flor-da-Vida/index.php?login_error=true");
            exit();
        }

    } elseif (isset($_POST['nome_admin']) && isset($_POST['senha_admin'])) {
        // Recebe os dados
        $nome_admin = $_POST['nome_admin'];
        $senha_admin = $_POST['senha_admin'];
    
        // Consulta no banco
        $sql_admin = "SELECT nome_admin FROM administradores WHERE  senha_admin = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("s", $senha_admin);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();
    
        if ($result_admin->num_rows > 0) {
            // Autenticação bem-sucedida
            $row = $result_admin->fetch_assoc();
            $_SESSION['nome_usuario'] = $row['nome_admin']; // Armazena na sessão
            $_SESSION['usuario'] = $nome_admin;
            header("Location: http://localhost/Hospital-Flor-da-Vida/pages/saudacao.php");
            exit();
        } else {
            // Erro de login
            $_SESSION['erro_mensagem'] = "Nome de usuário ou senha inválidos. Tente novamente."; // Mensagem de erro
            header("Location: http://localhost/Hospital-Flor-da-Vida/index.php?login_error=true");
            exit();
        }
    }
}
?>
