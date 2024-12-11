<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?></h1>
        <div class="grid">
        <a href="/cardapio/cozinha.php" class="card">
                <i class="fas fa-utensils"></i>
                <span>Cozinha</span>
            </a>
            <a href="/cardapio/cardapio.php" class="card">
                <i class="fas fa-book-open"></i>
                <span>Ver Cardápio</span>
            </a>
            <a href="pratos.php" class="card">
                <i class="fas fa-plus-circle"></i>
                <span>Gerenciar Pratos</span>
            </a>
            <a href="pedidos.php" class="card">
                <i class="fas fa-receipt"></i>
                <span>Pedidos</span>
            </a>
        </div>
    </div>
</body>
</html>
