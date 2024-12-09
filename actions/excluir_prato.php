<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM pratos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: ../admin/pratos.php');
        exit;
    } else {
        echo "Erro ao excluir prato.";
    }
}
?>
