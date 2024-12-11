<?php
include 'includes/db.php';

// Verifica se a conexão foi estabelecida corretamente
if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Executa a consulta no banco de dados
$query = "SELECT * FROM pratos";
$result = $conn->query($query);

if (!$result) {
    die("Erro ao buscar os pratos: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link rel="stylesheet" href="assets/css/cardapio.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-utensils"></i> Cardápio</h1>
        <div class="grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                        <div class="content">
                            <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
                            <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                            <p class="price">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                            <button onclick="adicionarAoCarrinho('<?php echo $row['nome']; ?>', '<?php echo $row['preco']; ?>', '<?php echo $row['imagem']; ?>')">Adicionar</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum prato encontrado no cardápio.</p>
            <?php endif; ?>
        </div>
        <div class="cart">
            <h2>Seu Carrinho</h2>
            <ul id="cartItems"></ul>
            <p>Total: R$ <span id="totalPrice">0.00</span></p>
            <form id="finalizeForm">
                <label for="nomeCliente">Nome:</label>
                <input type="text" id="nomeCliente" name="nome" required>
                <label for="numeroMesa">Mesa:</label>
                <input type="number" id="numeroMesa" name="mesa" required>
                <button type="button" onclick="finalizarPedido()">Finalizar Pedido</button>
            </form>
        </div>
    </div>
    <script src="./assets/js/cardapio.js"></script>
</body>
</html>
