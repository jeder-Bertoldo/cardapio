# CardápioApp

**CardápioApp** é um projeto desenvolvido para digitalizar o cardápio de restaurantes ou lanchonetes, permitindo que clientes realizem pedidos diretamente pelo celular e que os donos administrem o cardápio e os pedidos de forma simples e eficiente. Este projeto é uma aplicação híbrida, utilizando tecnologias web para o frontend e backend, integrada ao Android Studio por meio de um WebView.

## **Funcionalidades**

### **Para o Cliente:**
- Visualizar o cardápio com imagens e descrições.
- Adicionar itens ao carrinho.
- Finalizar o pedido informando o nome e número da mesa.

### **Para o Dono:**
- Fazer login para acessar áreas administrativas.
- Gerenciar pratos:
  - Adicionar novos pratos.
  - Editar pratos existentes.
  - Excluir pratos.
- Visualizar pedidos em tempo real na cozinha.
- Acompanhar estatísticas de pedidos e lucro do dia.
- Filtrar pedidos por data.

## **Tecnologias Utilizadas**

### **Frontend:**
- HTML, CSS e JavaScript para interfaces responsivas e modernas.
- Frameworks como SweetAlert2 para mensagens amigáveis ao usuário.

### **Backend:**
- PHP para lógica de negócio e manipulação de dados.
- MySQL para armazenamento de dados estruturados.

### **Integração com Android Studio:**
- WebView para incorporar o sistema web no aplicativo Android.
- Permissões e configurações adaptadas para acessos à rede local.

## **Estrutura do Projeto**

### **Diretórios e Arquivos Principais:**
- **`assets/`**: Contém arquivos de CSS, JavaScript e imagens.
- **`includes/`**: Scripts para conexão ao banco de dados e funções reutilizáveis.
- **`actions/`**: Scripts PHP para realizar ações como salvar pedidos e atualizar status.
- **`admin/`**: Páginas de gerenciamento para o dono do restaurante.
- **`index.php`**: Tela inicial com opções de login para o dono e acesso ao cardápio.
- **`pedidos.php`**: Painel de pedidos com estatísticas e filtros.
- **`cozinha.php`**: Visualização em tempo real dos pedidos na cozinha.

## **Como Executar o Projeto**

1. **Configuração Local:**
   - Instale o XAMPP ou outro servidor local.
   - Clone o repositório para o diretório do servidor (ex.: `htdocs` no XAMPP).
   - Importe o arquivo SQL do banco de dados para o MySQL.
   - Configure o arquivo de conexão `includes/db.php` com as credenciais do banco.

2. **Execução no Navegador:**
   - Acesse o sistema pelo navegador usando `http://localhost/caminho_do_projeto/`.

3. **Integração no Android Studio:**
   - Configure o WebView para carregar a URL do sistema.
   - Use o IP da máquina local no lugar de `localhost`.
   - Compile e instale o aplicativo no dispositivo.

## **Próximos Passos**
- Melhorar a navegabilidade no celular.
- Adicionar mais feedbacks visuais para os usuários.
- Implementar suporte a múltiplos idiomas.
- Explorar integração com sistemas de pagamento.

## **Contribuição**
Sugestões e melhorias são bem-vindas. Entre em contato para colaborar!

---
**Desenvolvedor:** Jeder



