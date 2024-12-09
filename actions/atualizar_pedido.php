<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE pedidos SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        echo "Status atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar status.";
    }
}
?>
