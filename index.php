<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hospital Flor da Vida</title>
    <!-- Inclua Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Exibir mensagem de erro, se houver -->
<?php if (isset($_SESSION['erro_mensagem'])): ?>
    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
        <?= htmlspecialchars($_SESSION['erro_mensagem']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['erro_mensagem']); // Remove a mensagem da sessão após exibir ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" type="image/x-icon">
    <title>Login - Hospital Flor da Vida</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Link do Bootstrap via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo dos botões */
        .btn-toggle {
            width: 150px;
            border-radius: 0;
            font-size: 1.2rem;
        }

        /* Esconde os formulários inicialmente */
        .form-container {
            display: none;
        }

        /* Exibe o formulário ativo */
        .form-container.active {
            display: block;
        }

        /* Estilo da mensagem de erro */
        .alert-error {
            display: none;
            margin-top: 10px;
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <!-- Exibir mensagem de erro se estiver presente -->
    <?php if (isset($erro_mensagem)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $erro_mensagem ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Menu do Site -->
    <nav class="navbar navbar-expand-lg navbar-light fs-6 pe-5 fixed-top color">
        <a class="navbar-brand ms-4 me-5" href="#">
            <img src="assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" alt="Hospital Flor da Vida" class="img-fluid" width="70">
        </a>
        <div>
            <span class="navbar-text fs-5" style="color: white;"><strong>LOGIN</strong> -  Hospital Flor da Vida</span>
        </div>
    </nav>

    <!-- Container principal -->
    <div class="container md-5" id="custom_container">
        <!-- Botões para selecionar o tipo de login -->
        <div class="text-center my-5">
            <button class="btn btn-primary btn-toggle" id="btn-paciente">Paciente</button>
            <button class="btn btn-secondary btn-toggle" id="btn-medico">Médico</button>
            <button class="btn btn-secondary  btn-toggle" id="btn-admin">Administração</button>
        </div>

        <!-- Formulários de Login -->
        <div class="row justify-content-center">
            <!-- Login de Pacientes -->
            <div class="col-md-5 form-container" id="form-paciente">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center">Paciente</h4>
                        <form action="./assets/controller/login_process.php" method="POST">
                            <!-- Campo de CPF -->
                            <div class="mb-3">
                                <label for="cpf_paciente" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf_paciente" name="cpf_paciente" placeholder="Digite seu CPF" maxlength="14" required>
                                <div class="invalid-feedback">CPF Inválido!</div>
                            </div>
                            <!-- Campo de Senha -->
                            <div class="mb-3">
                                <label for="senha_paciente" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha_paciente" name="senha_paciente" placeholder="Digite sua senha" required>
                            </div>
                            <!-- Link para recuperação de senha -->
                            <div class="mb-3 text-end">
                                <a href="#" class="text-decoration-none">Esqueceu a senha?</a>
                            </div>
                            <!-- Botão de Login -->
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Login de Médicos -->
            <div class="col-md-5 form-container" id="form-medico">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center">Médico</h4>
                        <form action="./assets/controller/login_process.php" method="POST">
                            <!-- Campo de CRM -->
                            <div class="mb-3">
                                <label for="crm_medico" class="form-label">CRM</label>
                                <input type="text" class="form-control" id="crm_medico" name="crm_medico" placeholder="Digite seu CRM" required>
                            </div>
                            <!-- Campo de Senha -->
                            <div class="mb-3">
                                <label for="senha_medico" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha_medico" name="senha_medico" placeholder="Digite sua senha" required>
                            </div>
                            <!-- Link para recuperação de senha -->
                            <div class="mb-3 text-end">
                                <a href="#" class="text-decoration-none">Esqueceu a senha?</a>
                            </div>
                            <!-- Botão de Login -->
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Login de Administração -->
            <div class="col-md-5 form-container" id="form-admin">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center">Administração</h4>
                        <form action="./assets/controller/login_process.php" method="POST">
                            <!-- Campo de CRM -->
                            <div class="mb-3">
                                <label for="crm_medico" class="form-label">Usuário</label>
                                <input type="text" class="form-control" id="nome_admin" name="nome_admin" placeholder="Digite seu usuário" required>
                            </div>
                            <!-- Campo de Senha -->
                            <div class="mb-3">
                                <label for="senha_medico" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha_admin" name="senha_admin" placeholder="Digite sua senha" required>
                            </div>
                            <!-- Link para recuperação de senha -->
                            <div class="mb-3 text-end">
                                <a href="#" class="text-decoration-none">Esqueceu a senha?</a>
                            </div>
                            <!-- Botão de Login -->
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé da página -->
    <footer class="bg-light text-dark mt-5">
        <div class="container py-4">
            <!-- Logo do Hospital -->
            <div class="row justify-content-center mb-4">
                <div class="w-100 col-md-3 mb-5 text-center ">
                    <img src="./assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" alt="Logo do Hospital Flor da Vida" class="img-fluid" style="max-width: 200px;">
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

    <!-- Meu JS -->
    <script src="assets/js/scripts.js"></script>
    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Máscara de CPF
        document.getElementById('cpf_paciente').addEventListener('input', function(e) {
            let cpf = e.target.value.replace(/\D/g, '');
            if (cpf.length <= 11) {
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1})/, '$1.$2.$3-$4');
            }
            e.target.value = cpf;
        });

        document.addEventListener('DOMContentLoaded', function () {
            const btnPaciente = document.getElementById('btn-paciente');
            const btnMedico = document.getElementById('btn-medico');
            const btnAdmin = document.getElementById('btn-admin');
            const formPaciente = document.getElementById('form-paciente');
            const formMedico = document.getElementById('form-medico');
            const formAdmin = document.getElementById('form-admin');

            // Exibir o formulário de paciente por padrão
            formPaciente.classList.add('active');
            btnPaciente.classList.remove('btn-secondary');
            btnPaciente.classList.add('btn-primary');

            btnPaciente.addEventListener('click', () => {
                formPaciente.classList.add('active');
                formMedico.classList.remove('active');
                formAdmin.classList.remove('active');
                btnPaciente.classList.remove('btn-secondary');
                btnPaciente.classList.add('btn-primary');
                btnMedico.classList.remove('btn-primary');
                btnMedico.classList.add('btn-secondary');
                btnAdmin.classList.remove('btn-primary');
                btnAdmin.classList.add('btn-secondary');
            });

            btnMedico.addEventListener('click', () => {
                formMedico.classList.add('active');
                formPaciente.classList.remove('active');
                formAdmin.classList.remove('active');
                btnMedico.classList.remove('btn-secondary');
                btnMedico.classList.add('btn-primary');
                btnPaciente.classList.remove('btn-primary');
                btnPaciente.classList.add('btn-secondary');
                btnAdmin.classList.remove('btn-primary');
                btnAdmin.classList.add('btn-secondary');
            });

            btnAdmin.addEventListener('click', () => {
                formAdmin.classList.add('active');
                formPaciente.classList.remove('active');
                formMedico.classList.remove('active');
                btnAdmin.classList.remove('btn-secondary');
                btnAdmin.classList.add('btn-primary');
                btnPaciente.classList.remove('btn-primary');
                btnPaciente.classList.add('btn-secondary');
                btnMedico.classList.remove('btn-primary');
                btnMedico.classList.add('btn-secondary');
            });
        });
    </script>
</body>
</html>
