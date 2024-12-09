<?php
// Configurações do banco de dados
$host = 'localhost'; // Endereço do servidor
$user = 'root';      // Usuário do banco de dados
$pass = '';          // Senha do banco de dados
$dbname = 'cardapio'; // Nome da base de dados

// Conexão ao banco de dados
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
