<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: login.php');
    exit;
}

include 'includes/db.php';

$query = "SELECT * FROM pedidos";
$result = $conn->query($query);
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
                <th>Imagem</th>
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
                    <td>
                        <img src="<?php echo htmlspecialchars($row['imagem_produto']); ?>" alt="Imagem do Prato" style="width: 50px; height: auto;">
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
