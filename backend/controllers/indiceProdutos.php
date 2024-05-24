<?php
require_once '../config/conn.php';

try {
    // Consulta SQL que junta as informações das tabelas `produtos` e `emprestimo`
    $sql = "SELECT p.id AS produto_id,
                   p.descricao AS produto,
                   p.tipo,
                   p.quantidade AS quantidade_total,
                   IFNULL(SUM(e.quantidade - e.devolvido), 0) AS quantidade_emprestada
            FROM produtos p
            LEFT JOIN emprestimo e ON p.id = e.produto AND e.status = 0
            GROUP BY p.id";

    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formatar cada quantidade como inteiro e preparar para o envio como JSON
    foreach ($produtos as $key => $produto) {
        $produtos[$key]['quantidade_total'] = (int) $produto['quantidade_total'];
        $produtos[$key]['quantidade_emprestada'] = (int) $produto['quantidade_emprestada'];
    }

    echo json_encode($produtos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
