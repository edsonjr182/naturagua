<?php
require_once '../../config/conn.php';

try {
    // Altere a consulta SQL para buscar dados relevantes da tabela `emprestimo`
    $sql = "SELECT e.id, e.cliente, e.produto, e.quantidade, e.devolvido, e.status, 
                   c.nome_razao_social as nome_cliente, p.descricao as nome_produto
            FROM emprestimo e
            JOIN clientes c ON e.cliente = c.id
            JOIN produtos p ON e.produto = p.id and e.status = 0";
    $stmt = $pdo->query($sql);
    $comodatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($comodatos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
