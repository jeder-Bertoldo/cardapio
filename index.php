<?php
include 'includes/db.php';

// Busca os pratos no banco de dados
$query = "SELECT * FROM pratos";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
</head>
<body>
    <h1>Cardápio</h1>
    <div id="cardapio">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="item">
                <h2><?php echo $row['nome']; ?></h2>
                <p><?php echo $row['descricao']; ?></p>
                <p><strong>Preço:</strong> R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>" style="width: 100px; height: auto;">
                <form method="POST" action="actions/adicionar_pedido.php">
                    <input type="hidden" name="imagem" value="<?php echo $row['imagem']; ?>">
                    <input type="hidden" name="total" value="<?php echo $row['preco']; ?>">
                    <label for="cliente_nome">Nome:</label>
                    <input type="text" name="cliente_nome" required>
                    <button type="submit">Fazer Pedido</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
