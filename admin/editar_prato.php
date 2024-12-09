<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pratos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $prato = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    // Configuração para upload de imagem
    $imagem = $_FILES['imagem'];
    $caminho_imagem = $prato['imagem']; // Mantém a imagem atual se nenhuma nova for enviada

    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $nome_imagem = uniqid() . '-' . basename($imagem['name']);
        $diretorio_destino = '../assets/img/';
        $caminho_imagem_novo = $diretorio_destino . $nome_imagem;

        if (move_uploaded_file($imagem['tmp_name'], $caminho_imagem_novo)) {
            $caminho_imagem = 'assets/img/' . $nome_imagem; // Atualiza o caminho no banco
        } else {
            $erro = "Erro ao salvar a nova imagem.";
        }
    }

    // Atualizar no banco de dados
    if (!isset($erro)) {
        $sql = "UPDATE pratos SET nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdsi', $nome, $descricao, $preco, $caminho_imagem, $id);

        if ($stmt->execute()) {
            header('Location: pratos.php');
            exit;
        } else {
            $erro = "Erro ao atualizar prato.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Prato</title>
</head>
<body>
    <div class="container">
        <h1>Editar Prato</h1>
        <?php if (isset($erro)): ?>
            <p style="color: red;"><?php echo $erro; ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $prato['id']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $prato['nome']; ?>" required>
            <br>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"><?php echo $prato['descricao']; ?></textarea>
            <br>
            <label for="preco">Preço:</label>
            <input type="number" step="0.01" id="preco" name="preco" value="<?php echo $prato['preco']; ?>" required>
            <br>
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">
            <br>
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
