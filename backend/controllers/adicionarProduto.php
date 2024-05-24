<?php
require_once '../config/conn.php';

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

if(isset($dados['descricao'], $dados['quantidade'], $dados['valorCusto'])) {
    try {
        $sql = "INSERT INTO produtos (descricao, quantidade, valor_custo) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['descricao'],
            $dados['quantidade'],
            $dados['valorCusto']
        ]);

        echo json_encode(['sucesso' => true, 'mensagem' => 'Produto adicionado com sucesso.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao adicionar o produto: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
}
