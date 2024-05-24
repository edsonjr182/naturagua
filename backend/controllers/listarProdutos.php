<?php
require_once '../config/conn.php';

try {
    $sql = "SELECT id, descricao, quantidade, valor_custo, (quantidade * valor_custo) AS valor_total FROM produtos";
    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formata o valor total como moeda
    foreach ($produtos as $key => $produto) {
        $produtos[$key]['valor_total'] = number_format($produto['valor_total'], 0, ',', '.');
        // Buscar emprestimos ativos do cliente
        $sqlEmprestimo = "SELECT SUM(quantidade - devolvido) AS quantidade_emprestada FROM emprestimo WHERE produto = ? AND status = 0";
        $stmtEmprestimo = $pdo->prepare($sqlEmprestimo);
        $stmtEmprestimo->execute([$produto['id']]);
        $emprestimo = $stmtEmprestimo->fetch(PDO::FETCH_ASSOC);
        $produtos[$key]['quantidade_emprestada'] = (int) $emprestimo['quantidade_emprestada'];


    }

    echo json_encode($produtos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao listar produtos: ' . $e->getMessage()]);
}
