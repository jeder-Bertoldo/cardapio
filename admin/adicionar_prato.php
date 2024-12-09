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
        $nome_imagem = uniqid() . '-' . basename($imagem['name']); // Nome único para evitar conflitos
        $diretorio_destino = '../assets/img/';
        $caminho_imagem = $diretorio_destino . $nome_imagem;

        // Move o arquivo para o diretório de destino
        if (!move_uploaded_file($imagem['tmp_name'], $caminho_imagem)) {
            $erro = "Erro ao salvar a imagem.";
        } else {
            $caminho_imagem = 'assets/img/' . $nome_imagem; // Caminho relativo para armazenar no banco
        }
    }

    // Inserir no banco de dados
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
</head>
<body>
    <div class="container">
        <h1>Adicionar Novo Prato</h1>
        <?php if (isset($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <br>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"></textarea>
            <br>
            <label for="preco">Preço:</label>
            <input type="number" step="0.01" id="preco" name="preco" required>
            <br>
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">
            <br>
            <button type="submit">Adicionar</button>
        </form>
    </div>
</body>
</html>
