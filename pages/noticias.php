<?php
include('../assets/controller/db_conexao.php'); // Conectar com o banco de dados

// Consulta para obter as notícias
$sqlNoticias = "SELECT titulo, resumo, data_publicacao FROM noticias ORDER BY data_publicacao DESC";
$stmtNoticias = $conn->prepare($sqlNoticias);
$stmtNoticias->execute();
$resultNoticias = $stmtNoticias->get_result();
$noticias = $resultNoticias->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/img/_a4fe6667-c233-41ab-a6a9-264c97b17558.jpeg" type="image/x-icon">
    <title>Notícias - Hospital Flor da Vida</title>
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
            <li class="nav-item"><a class="nav-link" href="#"></a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php">LOGIN</a></li>
            </ul>
        </div>
    </nav>

    <!-- Notícias principais -->
    <div id="carouselNoticias" class="carousel slide mt-5 pt-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach (array_slice($noticias, 0, 3) as $index => $noticia): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                    <img src="../assets/img/imagem_padrao.jpg" class="d-block w-100" alt="Notícia principal" style="height: 400px; object-fit: cover;">
                    <div class="carousel-caption d-none d-md-block">
                        <h5 class="text-dark"><?= htmlspecialchars($noticia['titulo']); ?></h5>
                        <p class="text-dark"><?= htmlspecialchars($noticia['resumo']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselNoticias" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselNoticias" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    </div>

    <!-- Lista de notícias -->
    <div class="container mt-4">
        <h2 class="text-white text-center">Últimas Notícias</h2>
        <div class="row">
            <?php foreach ($noticias as $noticia): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Imagem padrão -->
                        <img src="../assets/img/imagem_padrao.jpg" class="card-img-top" alt="Notícia" style="height: 200px; object-fit: cover;">
                        
                        <!-- Corpo do card -->
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($noticia['resumo']); ?></p>
                            <a href="#" class="btn btn-primary">Leia mais</a>
                        </div>
                        
                        <!-- Rodapé do card -->
                        <div class="card-footer text-muted">
                            Publicado em <?= date("d/m/Y", strtotime($noticia['data_publicacao'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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
<style>
    .card-img-top, 
.carousel .d-block {
    border-radius: 0 !important;
}
</style>
