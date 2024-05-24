<?php
require_once '../config/conn.php'; // Ajuste o caminho conforme necessário

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

// Validar campos baseados no tipo de transação
if (isset($dados['tipo_transacao'], $dados['produto_id'], $dados['quantidade']) && ($dados['tipo_transacao'] == 'venda' || $dados['tipo_transacao'] == 'avaria' || $dados['tipo_transacao'] == 'compra')) {
    // Somente os campos produto_id, tipo_transacao e quantidade são obrigatórios para venda, avaria e compra
    try {
        if ($dados['tipo_transacao'] == 'venda' || $dados['tipo_transacao'] == 'avaria') {
            // Verificar se há estoque suficiente
            $sqlEstoque = "SELECT quantidade FROM produtos WHERE id = ?";
            $stmtEstoque = $pdo->prepare($sqlEstoque);
            $stmtEstoque->execute([$dados['produto_id']]);
            $estoque = $stmtEstoque->fetchColumn();
            // Buscar produto e ver se ele pode ser emprestado
            $sqlProduto = "SELECT quantidade FROM produtos WHERE id = ?";
            $stmtProduto = $pdo->prepare($sqlProduto);
            $stmtProduto->execute([$dados['produto_id']]);
            $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);
            if (!$produto) {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Produto não encontrado.']);
                exit;
            }


            // Buscar emprestimos ativos do cliente
            $sqlEmprestimo = "SELECT SUM(quantidade - devolvido) AS quantidade_emprestada FROM emprestimo WHERE produto = ? AND status = 0";
            $stmtEmprestimo = $pdo->prepare($sqlEmprestimo);
            $stmtEmprestimo->execute([$dados['produto_id']]);
            $emprestimo = $stmtEmprestimo->fetch(PDO::FETCH_ASSOC);

            if ($produto['quantidade'] - $emprestimo['quantidade_emprestada'] < $dados['quantidade']) {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Quantidade insuficiente para operação.']);
                exit;
            }

            // Atualizar o estoque
            $novoEstoque = $estoque - $dados['quantidade'];
            $sqlUpdateEstoque = "UPDATE produtos SET quantidade = ? WHERE id = ?";
            $stmtUpdateEstoque = $pdo->prepare($sqlUpdateEstoque);
            $stmtUpdateEstoque->execute([$novoEstoque, $dados['produto_id']]);
        } else if ($dados['tipo_transacao'] == 'compra') {
            // Atualizar o estoque
            $sqlEstoque = "SELECT quantidade FROM produtos WHERE id = ?";
            $stmtEstoque = $pdo->prepare($sqlEstoque);
            $stmtEstoque->execute([$dados['produto_id']]);
            $estoque = $stmtEstoque->fetchColumn();
            $novoEstoque = $estoque + $dados['quantidade'];
            $sqlUpdateEstoque = "UPDATE produtos SET quantidade = ? WHERE id = ?";
            $stmtUpdateEstoque = $pdo->prepare($sqlUpdateEstoque);
            $stmtUpdateEstoque->execute([$novoEstoque, $dados['produto_id']]);
        }
        $sql = "INSERT INTO transacoes (produto_id, tipo_transacao, quantidade) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['produto_id'],
            $dados['tipo_transacao'],
            $dados['quantidade']
        ]);

        echo json_encode(['sucesso' => true, 'mensagem' => 'Transação registrada com sucesso.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao registrar a transação: ' . $e->getMessage()]);
    }
} elseif (isset($dados['tipo_transacao'], $dados['produto_id'], $dados['quantidade'], $dados['cliente_id']) && ($dados['tipo_transacao'] == 'comodato' || $dados['tipo_transacao'] == 'comodato_retorno')) {
    // Para comodato e comodato_retorno, todos os campos são obrigatórios
    try {
        $sql = "INSERT INTO transacoes (produto_id, tipo_transacao, cliente_id, quantidade) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['produto_id'],
            $dados['tipo_transacao'],
            $dados['cliente_id'],
            $dados['quantidade']
        ]);

        echo json_encode(['sucesso' => true, 'mensagem' => 'Transação de comodato registrada com sucesso.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao registrar a transação de comodato: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos ou tipo de transação inválido.']);
}
