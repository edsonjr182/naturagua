<?php
require_once '../config/conn.php';

// Lê o JSON do corpo da requisição e converte em um array PHP
$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson, true);

if(isset($dados['clienteId'])) {
    $clienteId = $dados['clienteId'];

    try {
        // Verificar se o cliente tem movimentos associados
        $sqlMovimentos = "SELECT COUNT(*) FROM transacoes WHERE cliente_id = ?";
        $stmtMovimentos = $pdo->prepare($sqlMovimentos);
        $stmtMovimentos->execute([$clienteId]);
        $movimentos = $stmtMovimentos->fetchColumn();

        if($movimentos > 0) {
            // Cliente tem movimentos associados, não pode ser excluído
            echo json_encode(['sucesso' => false, 'mensagem' => 'Este cliente possui movimentos associados e não pode ser deletado.']);
        } else {
            // Cliente não tem movimentos associados, pode ser excluído
            $sqlDeletar = "DELETE FROM clientes WHERE id = ?";
            $stmtDeletar = $pdo->prepare($sqlDeletar);
            $stmtDeletar->execute([$clienteId]);

            echo json_encode(['sucesso' => true, 'mensagem' => 'Cliente deletado com sucesso.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID do cliente não fornecido.']);
}

