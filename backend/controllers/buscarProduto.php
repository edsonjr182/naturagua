<?php
// Inclui o arquivo de conexão com o banco de dados
require_once '../config/conn.php';

// Verifica se o ID do produto foi fornecido
if (isset($_GET['id'])) {
    $produtoId = $_GET['id'];

    // Prepara a consulta SQL para buscar o produto pelo ID
    $sql = "SELECT tipo, descricao, quantidade, valor_custo FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $produtoId, PDO::PARAM_INT);
    $stmt->execute();

    // Busca o resultado
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o produto foi encontrado
    if ($produto) {
        // Calcula o valor total de custo do produto
        $produto['valor_total_custo'] = $produto['quantidade'] * $produto['valor_custo'];

        // Define o cabeçalho para retornar JSON
        header('Content-Type: application/json');
        // Retorna os dados em formato JSON
        echo json_encode($produto);
    } else {
        // Produto não encontrado
        echo json_encode(['message' => 'Produto não encontrado']);
    }
} else {
    // ID não fornecido
    echo json_encode(['message' => 'ID do produto não fornecido']);
}
?>
