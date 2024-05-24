<?php
// Inclui o arquivo de conexão com o banco de dados
require_once '../config/conn.php';

try {
    // Soma total de unidades em estoque
    $queryQuantidade = "SELECT SUM(quantidade) AS totalUnidades FROM produtos";
    $stmtQuantidade = $pdo->query($queryQuantidade);
    $totalUnidades = $stmtQuantidade->fetch(PDO::FETCH_ASSOC)['totalUnidades'];

    // Soma total de valor em estoque
    $queryValor = "SELECT SUM(quantidade * valor_custo) AS totalValor FROM produtos";
    $stmtValor = $pdo->query($queryValor);
    $totalValor = $stmtValor->fetch(PDO::FETCH_ASSOC)['totalValor'];

    // Formatar o total de valor como moeda
    $totalValorFormatado = number_format($totalValor, 0, ',', '.');

    echo json_encode(['totalUnidades' => $totalUnidades, 'totalValor' => $totalValorFormatado]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
