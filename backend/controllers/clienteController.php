<?php
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_razao_social = $_POST['nome_razao_social'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    $sql = "INSERT INTO clientes (nome_razao_social, cpf_cnpj, endereco, telefone) VALUES (:nome_razao_social, :cpf_cnpj, :endereco, :telefone)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nome_razao_social' => $nome_razao_social,
        'cpf_cnpj' => $cpf_cnpj,
        'endereco' => $endereco,
        'telefone' => $telefone
    ]);

    header('Location: ../../frontend/pages/cadastroCliente.php?sucesso=1');
    exit;
}
?>
