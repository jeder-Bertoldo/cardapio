<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Configuração para upload de imagem
    $imagem = $_FILES['imagem'];
    $caminho_imagem = null; // Caminho padrão (sem imagem)

    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $nome_imagem = uniqid() . '-' . basename($imagem['name']);
        $diretorio_destino = '../assets/img/';
        $caminho_imagem = $diretorio_destino . $nome_imagem;

        if (!move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
            $erro = "Erro ao salvar a imagem.";
        } else {
            $caminho_imagem = 'assets/img/' . $nome_imagem;
        }
    }

    if (!isset($erro)) {
        $sql = "INSERT INTO pratos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssds', $nome, $descricao, $preco, $caminho_imagem);

        if ($stmt->execute()) {
            header('Location: pratos.php');
            exit;
        } else {
            $erro = "Erro ao adicionar prato.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Prato</title>
    <link rel="stylesheet" href="../assets/css/adicionar_prato.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-plus-circle"></i> Adicionar Novo Prato</h1>
        <?php if (isset($erro)): ?>
            <p class="error"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" class="form-container">
            <div class="form-group">
                <label for="nome"><i class="fas fa-utensils"></i> Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="descricao"><i class="fas fa-align-left"></i> Descrição:</label>
                <textarea id="descricao" name="descricao"></textarea>
            </div>
            <div class="form-group">
                <label for="preco"><i class="fas fa-dollar-sign"></i> Preço:</label>
                <input type="number" step="0.01" id="preco" name="preco" required>
            </div>
            <div class="form-group">
                <label for="imagem"><i class="fas fa-image"></i> Imagem:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
            </div>
            <button type="submit" class="btn-submit"><i class="fas fa-check"></i> Adicionar</button>
        </form>
    </div>
</body>
</html>
