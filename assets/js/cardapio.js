let carrinho = [];
let total = 0;

function adicionarAoCarrinho(nome, preco, imagem) {
    carrinho.push({ nome, preco, imagem });
    total += parseFloat(preco);
    atualizarCarrinho();
    Swal.fire({
        title: 'Adicionado ao Carrinho',
        text: `${nome} foi adicionado ao seu carrinho.`,
        icon: 'success',
        timer: 1500,
        showConfirmButton: false,
    });
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
        Swal.fire({
            title: 'Erro',
            text: 'Por favor, preencha todos os campos!',
            icon: 'error',
            confirmButtonText: 'OK',
        });
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
            Swal.fire({
                title: 'Pedido Finalizado',
                text: data,
                icon: 'success',
                confirmButtonText: 'OK',
            }).then(() => {
                carrinho = [];
                total = 0;
                atualizarCarrinho();
            });
        })
        .catch(error => {
            Swal.fire({
                title: 'Erro',
                text: 'Houve um problema ao processar seu pedido. Tente novamente.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
            console.error('Erro:', error);
        });
}
