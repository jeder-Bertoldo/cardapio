<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php'; // Conexão com o banco
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pratos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciar Pratos</h1>
        <a href="adicionar_prato.php">Adicionar Novo Prato</a>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $query = "SELECT * FROM pratos";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['descricao']}</td>
                <td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>
                <td><img src='../{$row['imagem']}' alt='{$row['nome']}' style='width: 100px; height: auto;'></td>
                <td>
                    <a href='editar_prato.php?id={$row['id']}'>Editar</a> | 
                    <a href='../actions/excluir_prato.php?id={$row['id']}'>Excluir</a>
                </td>
              </tr>";
    }
    ?>
</tbody>

        </table>
    </div>
</body>
</html>
