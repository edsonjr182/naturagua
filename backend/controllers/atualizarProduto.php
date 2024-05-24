<?php
require_once '../config/conn.php';

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

// Certifique-se de que o ID do produto está incluído nos dados recebidos
if (isset($dados['produtoId'], $dados['descricao'], $dados['valor_custo'])) {
    try {
        // Comando SQL para atualizar o produto
        $sql = "UPDATE produtos SET descricao = ?, valor_custo = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['descricao'],
            $dados['valor_custo'],
            $dados['produtoId']
        ]);

        // Checa se algum registro foi atualizado
        if ($stmt->rowCount() > 0) {
            echo json_encode(['sucesso' => true, 'mensagem' => 'Produto atualizado com sucesso.']);
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Nenhuma alteração realizada ou produto não encontrado.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar o produto: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
}
