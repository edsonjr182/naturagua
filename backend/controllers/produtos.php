<?php
// Inclui o arquivo de conexão com o banco de dados
require_once '../config/conn.php';

// Prepara a consulta SQL para buscar todos os produtos
$sql = "SELECT tipo, quantidade, valor_custo FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Busca os resultados
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcula o valor total de custo para cada produto
foreach ($produtos as $key => $produto) {
    $produtos[$key]['valor_total_custo'] = $produto['quantidade'] * $produto['valor_custo'];
}

// Define o cabeçalho para retornar JSON
header('Content-Type: application/json');
// Retorna os dados em formato JSON
echo json_encode($produtos);
