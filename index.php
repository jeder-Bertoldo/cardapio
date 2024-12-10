<?php
include 'includes/db.php';

// Busca os pratos no banco de dados
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 5px;
        }

        .item img {
            width: 100px;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        .cart {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 5px;
        }

        .cart-total {
            font-weight: bold;
            margin-top: 10px;
        }

        .finalize-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .finalize-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Cardápio</h1>
    <div id="cardapio">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="item">
                <h2><?php echo $row['nome']; ?></h2>
                <p><?php echo $row['descricao']; ?></p>
                <p><strong>Preço:</strong> R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>">
                <button onclick="adicionarAoCarrinho('<?php echo $row['nome']; ?>', '<?php echo $row['preco']; ?>', '<?php echo $row['imagem']; ?>')">Adicionar ao Carrinho</button>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="cart">
        <h3>Seu Carrinho</h3>
        <ul id="cartItems"></ul>
        <p class="cart-total">Total: R$ <span id="totalPrice">0.00</span></p>
        <form id="finalizeForm">
            <label for="nomeCliente">Nome:</label>
            <input type="text" id="nomeCliente" name="nome" required>
            <label for="numeroMesa">Número da Mesa:</label>
            <input type="number" id="numeroMesa" name="mesa" required>
            <button type="button" class="finalize-button" onclick="finalizarPedido()">Finalizar Pedido</button>
        </form>
    </div>

    <script>
        let carrinho = [];
        let total = 0;

        function adicionarAoCarrinho(nome, preco, imagem) {
            carrinho.push({ nome, preco, imagem });
            total += parseFloat(preco);

            atualizarCarrinho();
        }

        function atualizarCarrinho() {
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';

            carrinho.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.nome} - R$ ${parseFloat(item.preco).toFixed(2)}`;
                cartItems.appendChild(li);
            });

            document.getElementById('totalPrice').textContent = total.toFixed(2);
        }

        function finalizarPedido() {
            const nomeCliente = document.getElementById('nomeCliente').value;
            const numeroMesa = document.getElementById('numeroMesa').value;

            if (!nomeCliente || !numeroMesa) {
                alert("Por favor, preencha todos os campos!");
                return;
            }

            const formData = new FormData();
            formData.append('nome', nomeCliente);
            formData.append('mesa', numeroMesa);
            formData.append('total', total);

            carrinho.forEach((item, index) => {
                formData.append(`item_nome_${index}`, item.nome);
                formData.append(`item_preco_${index}`, item.preco);
                formData.append(`item_imagem_${index}`, item.imagem);
            });

            fetch('actions/salvar_pedido.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    carrinho = [];
                    total = 0;
                    atualizarCarrinho();
                })
                .catch(error => console.error('Erro:', error));
        }
    </script>
</body>
</html>
