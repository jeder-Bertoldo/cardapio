<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $mesa = $_POST['mesa'];
    $total = $_POST['total'];

    $sql = "INSERT INTO pedidos (cliente_nome, mesa, total) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sid', $nome, $mesa, $total);

    if ($stmt->execute()) {
        $pedido_id = $stmt->insert_id;

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'item_nome_') === 0) {
                $index = str_replace('item_nome_', '', $key);
                $itens[$index]['nome'] = $value;
            } elseif (strpos($key, 'item_preco_') === 0) {
                $index = str_replace('item_preco_', '', $key);
                $itens[$index]['preco'] = $value;
            } elseif (strpos($key, 'item_imagem_') === 0) {
                $index = str_replace('item_imagem_', '', $key);
                $itens[$index]['imagem'] = $value;
            }
        }

        foreach ($itens as $item) {
            $sql_item = "INSERT INTO pedido_itens (pedido_id, nome, preco, imagem) VALUES (?, ?, ?, ?)";
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param('isds', $pedido_id, $item['nome'], $item['preco'], $item['imagem']);
            $stmt_item->execute();
        }

        echo "Pedido registrado com sucesso!";
    } else {
        echo "Erro ao registrar o pedido.";
    }
}
?>
