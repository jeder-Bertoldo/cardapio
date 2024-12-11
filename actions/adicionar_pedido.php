<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagem_produto = $_POST['imagem']; // Apenas o caminho da imagem
    $total = $_POST['total'];
    $cliente_nome = $_POST['cliente_nome'] ?? 'Cliente Anônimo';

    $sql = "INSERT INTO pedidos (cliente_nome, imagem_produto, total) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssd', $cliente_nome, $imagem_produto, $total);

    if ($stmt->execute()) {
        header('Location: ../cardapio.php?status=success');
        exit;
    } else {
        header('Location: ../cardapio.php?status=error');
        exit;
    }
    
}
?>
