# Cardápio Digital - Restaurante/Lanchonete 🍽️📱

## **Descrição do Projeto**
O **Cardápio Digital** é um sistema que facilita pedidos em restaurantes e lanchonetes. O cliente pode visualizar o cardápio, adicionar itens a um carrinho e enviar o pedido diretamente para a cozinha. O dono do restaurante pode gerenciar pratos, visualizar pedidos em tempo real e acompanhar o lucro do dia.

---

## **Funcionalidades**

### **Para o Cliente**:
1. **Visualização do Cardápio**:
   - Itens organizados com nome, descrição, preço e imagem.
   - Design responsivo para dispositivos móveis.

2. **Carrinho de Compras**:
   - Adicionar ou remover itens do pedido.
   - Informar o nome do cliente e o número da mesa antes de finalizar o pedido.

3. **Envio de Pedido**:
   - Pedido enviado diretamente para a **Cozinha**.

---

### **Para o Dono do Restaurante**:
1. **Login Seguro**:
   - Tela de login protegida por senha criptografada (**`password_hash`**).

2. **Dashboard**:
   - Tela centralizada para acessar:
     - Cozinha
     - Cardápio
     - Cadastro de Pratos
     - Gerenciamento de Pedidos

3. **Gerenciamento de Pratos**:
   - **Adicionar**, **editar** e **excluir** pratos.
   - Upload de imagens diretamente do celular ou computador.

4. **Visualização da Cozinha**:
   - Pedidos exibidos em tempo real.
   - Status do pedido pode ser atualizado:
     - **Pendente**, **Preparando** e **Pronto**.
   - Pedidos com status "Pronto" desaparecem automaticamente da tela.

5. **Gerenciamento de Pedidos**:
   - Tela com **filtros** para visualizar pedidos por data.
   - Exibição do **lucro diário** e quantidade de clientes atendidos.

---

## **Tecnologias Utilizadas**

### **Frontend**:
- HTML5
- CSS3 (com design responsivo)
- JavaScript
- SweetAlert2 (para notificações modernas)
- Ícones: Font Awesome

### **Backend**:
- PHP (procedural)
- MySQL (banco de dados)

### **Mobile**:
- **WebView** no Android Studio:
   - Exibe o sistema no formato de aplicativo.
   - Com suporte a **upload de imagens** e navegação eficiente.

---

## **Requisitos**

1. **Servidor Local**:
   - XAMPP ou WAMP instalado para rodar o PHP e MySQL.

2. **Banco de Dados**:
   - Importe o arquivo **`cardapio.sql`** para o MySQL.

3. **Android Studio**:
   - Configurado com o emulador ou dispositivo físico.
   - WebView configurado para acessar o servidor local via IP.

---

## **Instalação**

### **1. Configuração do Backend:**
1. Clone o repositório para a pasta do servidor local:
   ```bash
   git clone https://github.com/seu-repositorio/cardapio-digital.git
