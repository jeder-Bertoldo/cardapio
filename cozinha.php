<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: login.php');
    exit;
}

include 'includes/db.php';

// Consulta os pedidos no banco de dados, excluindo os que estão "Pronto"
$query = "SELECT * FROM pedidos WHERE status != 'Pronto'";
$result = $conn->query($query);

if (!$result) {
    die("Erro ao buscar os pedidos: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Cozinha</title>
</head>
<body>
    <h1>Pedidos na Cozinha</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Mesa</th>
                <th>Itens</th>
                <th>Total</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['cliente_nome']); ?></td>
                    <td><?php echo htmlspecialchars($row['mesa']); ?></td>
                    <td>
                        <?php
                        // Busca os itens relacionados ao pedido na tabela pedido_itens
                        $pedido_id = $row['id'];
                        $query_itens = "SELECT nome, imagem FROM pedido_itens WHERE pedido_id = ?";
                        $stmt_itens = $conn->prepare($query_itens);
                        $stmt_itens->bind_param('i', $pedido_id);
                        $stmt_itens->execute();
                        $result_itens = $stmt_itens->get_result();

                        if ($result_itens->num_rows > 0) {
                            while ($item = $result_itens->fetch_assoc()) {
                                $imagem = !empty($item['imagem']) ? htmlspecialchars($item['imagem']) : 'assets/img/imagem_padrao.jpg';
                                echo "<div style='margin-bottom: 10px;'>
                                        <img src='$imagem' alt='Imagem do Item' style='width: 50px; height: auto; margin-right: 10px;'>
                                        " . htmlspecialchars($item['nome']) . "
                                      </div>";
                            }
                        } else {
                            echo "Nenhum item encontrado.";
                        }
                        ?>
                    </td>
                    <td>R$ <?php echo number_format($row['total'], 2, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <form method="POST" action="/cardapio/actions/atualizar_pedido.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="Pendente" <?php echo $row['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                                <option value="Preparando" <?php echo $row['status'] === 'Preparando' ? 'selected' : ''; ?>>Preparando</option>
                                <option value="Pronto" <?php echo $row['status'] === 'Pronto' ? 'selected' : ''; ?>>Pronto</option>
                            </select>
                            <button type="submit">Atualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
