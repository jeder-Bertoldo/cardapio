<?php
session_start();
if (!isset($_SESSION['dono_logado'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/db.php';

// Obtém a data selecionada (ou a data atual como padrão)
$dataSelecionada = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

// Busca os pedidos do dia selecionado
$query = "SELECT * FROM pedidos WHERE DATE(criado_em) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $dataSelecionada);
$stmt->execute();
$result = $stmt->get_result();

// Calcula o número de clientes e o lucro total
$totalClientes = 0;
$lucroTotal = 0;
while ($row = $result->fetch_assoc()) {
    $totalClientes++;
    $lucroTotal += $row['total'];
}

// Reinicia o resultado para exibição
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos do Dia</title>
    <link rel="stylesheet" href="../assets/css/pedidos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-chart-line"></i> Pedidos e Estatísticas</h1>

        <!-- Estatísticas e Filtro -->
        <div class="stats-container">
            <form method="GET" action="pedidos.php" class="filter-form">
                <label for="data">
                    <i class="fas fa-calendar-alt"></i> Escolha a Data:
                </label>
                <input type="date" id="data" name="data" value="<?php echo $dataSelecionada; ?>" required>
                <button type="submit" class="btn-filter">Filtrar</button>
            </form>
            <div class="stats">
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <p>Clientes</p>
                    <strong><?php echo $totalClientes; ?></strong>
                </div>
                <div class="stat-item">
                    <i class="fas fa-dollar-sign"></i>
                    <p>Lucro</p>
                    <strong>R$ <?php echo number_format($lucroTotal, 2, ',', '.'); ?></strong>
                </div>
            </div>
        </div>

        <!-- Tabela de Pedidos -->
        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Mesa</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['cliente_nome']); ?></td>
                                <td><?php echo htmlspecialchars($row['mesa']); ?></td>
                                <td>R$ <?php echo number_format($row['total'], 2, ',', '.'); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo date('H:i:s', strtotime($row['criado_em'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">Nenhum pedido registrado nesta data.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
