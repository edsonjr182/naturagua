<?php
require_once '../../config/conn.php'; // Ajuste o caminho conforme necessário

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

// Validação básica para garantir que todos os campos necessários estão presentes
if (isset($dados['cliente'], $dados['produto'], $dados['quantidade'])) {
    try {
        // Buscar produto e ver se ele pode ser emprestado
        $sqlProduto = "SELECT quantidade FROM produtos WHERE id = ?";
        $stmtProduto = $pdo->prepare($sqlProduto);
        $stmtProduto->execute([$dados['produto']]);
        $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);
        if (!$produto) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Produto não encontrado.']);
            exit;
        }
        

        // Buscar emprestimos ativos do cliente
        $sqlEmprestimo = "SELECT SUM(quantidade - devolvido) AS quantidade_emprestada FROM emprestimo WHERE produto = ? AND status = 0";
        $stmtEmprestimo = $pdo->prepare($sqlEmprestimo);
        $stmtEmprestimo->execute([$dados['produto']]);
        $emprestimo = $stmtEmprestimo->fetch(PDO::FETCH_ASSOC);

        if ($produto['quantidade'] - $emprestimo['quantidade_emprestada'] < $dados['quantidade']) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Quantidade insuficiente para empréstimo.']);
            exit;
        }


        $sql = "INSERT INTO emprestimo (cliente, produto, quantidade, devolvido, status) VALUES (?, ?, ?, 0, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['cliente'],
            $dados['produto'],
            $dados['quantidade']
        ]);

        // Assumindo que o código anterior já foi executado e que a inserção no empréstimo foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            // Inserção na tabela transacoes
            try {
                $sqlTransacao = "INSERT INTO transacoes (produto_id, tipo_transacao, cliente_id, quantidade, data_transacao) VALUES (?, 'comodato', ?, ?, NOW())";
                $stmtTransacao = $pdo->prepare($sqlTransacao);
                $stmtTransacao->execute([
                    $dados['produto'],
                    $dados['cliente'],
                    $dados['quantidade']
                ]);

                // Checa se a transação foi registrada com sucesso
                if ($stmtTransacao->rowCount() > 0) {
                    echo json_encode(['sucesso' => true, 'mensagem' => 'Empréstimo e transação registrados com sucesso.']);
                } else {
                    throw new Exception("Erro ao registrar a transação.");
                }
            } catch (PDOException $e) {
                // Se houver erro na inserção na tabela transacoes, retorna um erro
                http_response_code(500);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao adicionar a transação: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao adicionar o registro de empréstimo: nenhuma linha afetada.']);
        }
    } catch (PDOException $e) {
        // Retorna erro se algo der errado
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao adicionar o registro de empréstimo: ' . $e->getMessage()]);
    }
} else {
    // Retorna erro se algum campo estiver faltando
    echo json_encode(['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.']);
}
