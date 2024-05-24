<?php
require_once '../../config/conn.php';

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

// Certifique-se de que o ID do empréstimo e a quantidade devolvida estão incluídos nos dados recebidos
if (isset($dados['emprestimoId'], $dados['quantidadeDevolvida'])) {
    $emprestimoId = $dados['emprestimoId'];
    $quantidadeDevolvida = $dados['quantidadeDevolvida'];

    try {
        // Inicia a transação
        $pdo->beginTransaction();

        // Busca a quantidade emprestada e a quantidade já devolvida
        $sql = "SELECT quantidade, devolvido, cliente, produto FROM emprestimo WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$emprestimoId]);
        $emprestimo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($emprestimo) {
            $novaQuantidadeDevolvida = $emprestimo['devolvido'] + $quantidadeDevolvida;

            // Atualiza o campo devolvido
            $sqlUpdate = "UPDATE emprestimo SET devolvido = ? WHERE id = ?";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([$novaQuantidadeDevolvida, $emprestimoId]);

            // Insere registro de devolução na tabela transacoes
            $sqlTransacao = "INSERT INTO transacoes (produto_id, tipo_transacao, cliente_id, quantidade, data_transacao) VALUES (?, 'comodato_retorno', ?, ?, NOW())";
            $stmtTransacao = $pdo->prepare($sqlTransacao);
            $stmtTransacao->execute([
                $emprestimo['produto'],
                $emprestimo['cliente'],
                $quantidadeDevolvida
            ]);

            // Verifica se a quantidade devolvida é igual à quantidade emprestada
            if ($novaQuantidadeDevolvida >= $emprestimo['quantidade']) {
                // Atualiza o status para 1
                $sqlStatus = "UPDATE emprestimo SET status = 1 WHERE id = ?";
                $stmtStatus = $pdo->prepare($sqlStatus);
                $stmtStatus->execute([$emprestimoId]);
            }

            // Finaliza a transação
            $pdo->commit();
            echo json_encode(['sucesso' => true, 'mensagem' => 'Devolução e transação de retorno processadas com sucesso.']);
        } else {
            throw new Exception('Empréstimo não encontrado.');
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro na base de dados: ' . $e->getMessage()]);
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
}
