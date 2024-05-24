<?php
require_once '../config/conn.php';

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

if(isset($dados['produtoId'])) {
    $produtoId = $dados['produtoId'];

    try {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$produtoId]);

        echo json_encode(['sucesso' => true, 'mensagem' => 'Produto deletado com sucesso.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao deletar o produto: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID do produto não fornecido.']);
}
