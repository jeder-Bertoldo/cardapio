<?php
session_start();
include 'includes/db.php'; // Conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['senha'])) {
            $_SESSION['dono_logado'] = true;
            $_SESSION['usuario_nome'] = $user['nome'];
            header('Location: admin/dashboard.php');
            exit;
        } else {
            $erro = "Senha inválida.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Dono</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login do Dono</h1>
            <?php if (isset($erro)): ?>
                <p class="error"><?php echo $erro; ?></p>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <div class="input-group">
                        <i class="fas fa-user icon"></i>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <div class="input-group">
                        <i class="fas fa-key icon"></i>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
