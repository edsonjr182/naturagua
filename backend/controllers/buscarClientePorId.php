<?php
require_once '../config/conn.php';

// Verifica se o ID do cliente foi enviado
if(isset($_GET['clienteId'])) {
    $clienteId = $_GET['clienteId'];

    try {
        // Prepara e executa a consulta para buscar os dados do cliente
        $sql = "SELECT id, nome_razao_social, cpf_cnpj, endereco, telefone FROM clientes WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$clienteId]);

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if($cliente) {
            // Retorna os dados do cliente em formato JSON
            echo json_encode($cliente);
        } else {
            // Caso não encontre o cliente, retorna um erro
            echo json_encode(['erro' => 'Cliente não encontrado.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['erro' => $e->getMessage()]);
    }
} else {
    echo json_encode(['erro' => 'ID do cliente não fornecido.']);
}
