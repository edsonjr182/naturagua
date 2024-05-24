<?php
require_once '../config/conn.php';

try {
    $sql = "SELECT id, nome_razao_social, cpf_cnpj, endereco, telefone FROM clientes";
    $stmt = $pdo->query($sql);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($clientes);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
