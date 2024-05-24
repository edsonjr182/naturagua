<?php
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_id = $_POST['produto_id'];
    $tipo_transacao = $_POST['tipo_transacao'];
    $quantidade = $_POST['quantidade'];
    $cliente_id = null;
    
     // Verifica se a quantidade é um número inteiro e não negativo
    if (!filter_var($quantidade, FILTER_VALIDATE_INT) || (int)$quantidade < 0) {
        // Redireciona para a página de movimento com mensagem de erro
        header('Location: ../../frontend/movimento.php?erro=' . urlencode('Quantidade inválida.'));
        exit; // Encerra a execução do script
    }

    // Verificação para comodato
    if ($tipo_transacao == 'comodato') {
        $cliente_id = $_POST['cliente_id'];
    }

    // Inicia uma transação
    $pdo->beginTransaction();

    try {
        // Verifica a quantidade disponível para venda ou avaria
        if ($tipo_transacao === 'venda' || $tipo_transacao === 'avaria') {
            $sqlCheck = "SELECT quantidade FROM produtos WHERE id = :produto_id";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute(['produto_id' => $produto_id]);
            $produto = $stmtCheck->fetch();

            if ($produto['quantidade'] < $quantidade) {
                // Não há quantidade suficiente para a transação
                throw new Exception("Quantidade insuficiente em estoque.");
            }

            $sqlUpdate = "UPDATE produtos SET quantidade = quantidade - :quantidade WHERE id = :produto_id";
        } elseif ($tipo_transacao === 'comodato_retorno') {
            $sqlUpdate = "UPDATE produtos SET quantidade = quantidade + :quantidade WHERE id = :produto_id";
        }

        // Atualiza a quantidade do produto
        if (isset($sqlUpdate)) {
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->execute(['quantidade' => $quantidade, 'produto_id' => $produto_id]);
        }

        // Insere a transação
        $sql = "INSERT INTO transacoes (produto_id, tipo_transacao, cliente_id, quantidade) VALUES (:produto_id, :tipo_transacao, :cliente_id, :quantidade)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'produto_id' => $produto_id,
            'tipo_transacao' => $tipo_transacao,
            'cliente_id' => $cliente_id,
            'quantidade' => $quantidade
        ]);

        // Se tudo estiver ok, commita a transação
        $pdo->commit();

        header('Location: ../../frontend/movimento.php?sucesso=1');
    } catch (Exception $e) {
        // Em caso de erro, faz rollback e retorna mensagem de erro
        $pdo->rollBack();
        header('Location: ../../frontend/movimento.php?erro=' . urlencode($e->getMessage()));
    }
    exit;
}
?>
