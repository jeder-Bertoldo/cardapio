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
