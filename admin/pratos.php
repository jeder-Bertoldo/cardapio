<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

// Consulta os pratos existentes no banco
$query = "SELECT * FROM pratos";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Pratos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/pratos.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-utensils"></i> Gerenciar Pratos</h1>
        <div class="actions">
            <a href="adicionar_prato.php" class="btn-add">
                <i class="fas fa-plus-circle"></i> Adicionar Novo Prato
            </a>
        </div>
        <div class="grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <img src="../<?php echo htmlspecialchars($row['imagem']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                        <div class="content">
                            <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
                            <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                            <p class="price">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                            <div class="actions">
                                <a href="editar_prato.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="javascript:void(0);" class="btn-delete" onclick="confirmarExclusao(<?php echo $row['id']; ?>)">
    <i class="fas fa-trash"></i> Excluir
</a>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarExclusao(id) {
    Swal.fire({
        title: 'Confirmação',
        text: 'Tem certeza que deseja excluir este prato?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Redireciona para excluir o prato
            window.location.href = `excluir_prato.php?id=${id}`;
        }
    });
}
</script>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">Nenhum prato cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
