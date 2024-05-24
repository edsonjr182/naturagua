<?php
// Inclui o arquivo de conexão com o banco de dados
require_once '../config/conn.php';

try {
    // Query que junta as informações necessárias das tabelas 'transacoes', 'clientes' e 'produtos'
    $query = "SELECT t.id AS transacao_id, t.cliente_id, t.produto_id, t.tipo_transacao, 
                     COALESCE(c.nome_razao_social, 'Não informado') AS cliente, p.descricao AS produto, 
                     t.quantidade AS quantidade_total, 
                     (t.quantidade * p.valor_custo) AS valor_total
              FROM transacoes t
              LEFT JOIN clientes c ON t.cliente_id = c.id
              JOIN produtos p ON t.produto_id = p.id ORDER BY t.data_transacao DESC
              LIMIT 15";

    $stmt = $pdo->query($query);
    $transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Formatar o valor total como moeda
    foreach ($transacoes as $key => $transacao) {
        $transacoes[$key]['valor_total'] = number_format($transacao['valor_total'], 2, ',', '.');
    }

    echo json_encode($transacoes);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
