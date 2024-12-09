<?php
session_start();
include 'includes/db.php'; // Conexão ao banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar no banco de dados se o usuário existe
    $sql = "SELECT * FROM usuarios WHERE username = ? AND password = MD5(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Usuário autenticado, cria a sessão
        $_SESSION['dono_logado'] = true;
        header('Location: admin/dashboard.php'); // Redireciona para o painel
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dono do Restaurante</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login do Dono</h1>
        <?php if (isset($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
