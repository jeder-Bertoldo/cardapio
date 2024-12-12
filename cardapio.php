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
    <link rel="stylesheet" href="./assets/css/cardapio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Modal de Feedback -->
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            Swal.fire({
                title: 'Pedido Registrado!',
                text: 'Seu pedido foi registrado com sucesso.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        } else if (status === 'error') {
            Swal.fire({
                title: 'Erro!',
                text: 'Ocorreu um problema ao registrar seu pedido. Tente novamente.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Título do Cardápio -->
        <h1><i class="fas fa-utensils"></i> Cardápio</h1>

        <!-- Grid de Pratos -->
        <div class="grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                        <div class="content">
                            <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
                            <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                            <p class="price">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                            <button onclick="adicionarAoCarrinho('<?php echo $row['nome']; ?>', '<?php echo $row['preco']; ?>', '<?php echo $row['imagem']; ?>')">
                                Adicionar
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum prato encontrado no cardápio.</p>
            <?php endif; ?>
        </div>

        <!-- Carrinho -->
        <div class="cart">
            <h2><i class="fas fa-shopping-cart"></i> Seu Carrinho</h2>
            <ul id="cartItems"></ul>
            <div class="cart-summary">
                <p>Total: R$ <span id="totalPrice">0.00</span></p>
            </div>
            <form id="finalizeForm">
                <label for="nomeCliente">
                    <i class="fas fa-user"></i> Nome do Cliente:
                </label>
                <input type="text" id="nomeCliente" name="nome" required>

                <label for="numeroMesa">
                    <i class="fas fa-chair"></i> Número da Mesa:
                </label>
                <input type="number" id="numeroMesa" name="mesa" required>

                <button type="button" class="finalize-button" onclick="finalizarPedido()">
                    <i class="fas fa-check-circle"></i> Finalizar Pedido
                </button>
            </form>
        </div>
    </div>

    <!-- Script do Cardápio -->
    <script src="./assets/js/cardapio.js"></script>
</body>
</html>
