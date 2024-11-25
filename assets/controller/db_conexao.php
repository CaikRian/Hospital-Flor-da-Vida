<?php
// Configurações do banco de dados
$servername = "localhost"; // O servidor MySQL
$username = "root"; // Usuário padrão do MySQL no XAMPP
$password = ""; // Senha padrão do MySQL no XAMPP (em branco)
$dbname = "hospitalflordavida"; // Nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


?>