<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

// Verifica se o ID foi enviado via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Garante que o ID seja um número inteiro

    // Consulta para verificar se o prato existe
    $checkQuery = "SELECT imagem FROM pratos WHERE id = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param('i', $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Prato encontrado, obtém o caminho da imagem
        $prato = $resultCheck->fetch_assoc();
        $imagemPath = '../' . $prato['imagem'];

        // Exclui o prato do banco de dados
        $deleteQuery = "DELETE FROM pratos WHERE id = ?";
        $stmtDelete = $conn->prepare($deleteQuery);
        $stmtDelete->bind_param('i', $id);

        if ($stmtDelete->execute()) {
            // Exclui a imagem do servidor, se existir
            if (file_exists($imagemPath)) {
                unlink($imagemPath);
            }

            // Redireciona com sucesso
            header('Location: pratos.php?status=success');
            exit;
        } else {
            // Erro ao excluir do banco
            header('Location: pratos.php?status=error');
            exit;
        }
    } else {
        // Prato não encontrado
        header('Location: pratos.php?status=notfound');
        exit;
    }
} else {
    // ID não fornecido
    header('Location: pratos.php?status=invalid');
    exit;
}
?>
