<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: login.php');
    exit;
}

include 'includes/db.php';

// Consulta pedidos (exceto os com status "Pronto")
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
    <title>Cozinha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/cardapio/assets/css/cozinha.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-utensils"></i> Pedidos na Cozinha</h1>
        
        <div class="top-button">
    <a href="cardapio.php" class="btn-cardapio">Ir para o Cardápio</a>
</div>

        <div class="pedidos">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="pedido-card">
                    <h2>Pedido #<?php echo $row['id']; ?></h2>
                    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($row['cliente_nome']); ?></p>
                    <p><strong>Mesa:</strong> <?php echo htmlspecialchars($row['mesa']); ?></p>
                    <p><strong>Total:</strong> R$ <?php echo number_format($row['total'], 2, ',', '.'); ?></p>
                    <div class="itens">
                        <?php
                        $pedido_id = $row['id'];
                        $query_itens = "SELECT nome, imagem FROM pedido_itens WHERE pedido_id = ?";
                        $stmt_itens = $conn->prepare($query_itens);
                        $stmt_itens->bind_param('i', $pedido_id);
                        $stmt_itens->execute();
                        $result_itens = $stmt_itens->get_result();

                        while ($item = $result_itens->fetch_assoc()): ?>
                            <div class="item">
                                <img src="<?php echo htmlspecialchars($item['imagem']); ?>" alt="Imagem do Item">
                                <span><?php echo htmlspecialchars($item['nome']); ?></span>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <form method="POST" action="/cardapio/actions/atualizar_pedido.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <select name="status">
                            <option value="Pendente" <?php echo $row['status'] === 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                            <option value="Preparando" <?php echo $row['status'] === 'Preparando' ? 'selected' : ''; ?>>Preparando</option>
                            <option value="Pronto" <?php echo $row['status'] === 'Pronto' ? 'selected' : ''; ?>>Pronto</option>
                        </select>
                        <button type="submit">Atualizar</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
