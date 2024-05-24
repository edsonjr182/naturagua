<?php
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor_custo = $_POST['valor_custo'];

    $sql = "INSERT INTO produtos (tipo, descricao, quantidade, valor_custo) VALUES (:tipo, :descricao, :quantidade, :valor_custo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'tipo' => $tipo,
        'descricao' => $descricao,
        'quantidade' => $quantidade,
        'valor_custo' => $valor_custo
    ]);

    header('Location: ../../frontend/produtos.php?sucesso=1');
    exit;
}
?>
