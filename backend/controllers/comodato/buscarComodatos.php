<?php
require_once '../../config/conn.php';
header("Content-Type: application/json");

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$filtroCliente = $data['filtro'] ?? '';  // Pega o filtro do cliente ou default vazio

try {
    $filtroCliente = "%{$filtroCliente}%"; // Prepara o filtro para a consulta LIKE
    $sql = "SELECT e.id, e.cliente, e.produto, e.quantidade, e.devolvido, e.status, 
                   c.nome_razao_social as nome_cliente, p.descricao as nome_produto
            FROM emprestimo e
            JOIN clientes c ON e.cliente = c.id
            JOIN produtos p ON e.produto = p.id
            WHERE e.status = 0 AND c.nome_razao_social LIKE :filtroCliente";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':filtroCliente', $filtroCliente, PDO::PARAM_STR);
    $stmt->execute();
    $comodatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($comodatos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
