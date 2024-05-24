<?php
require_once '../config/conn.php';

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

if(isset($dados['clienteId']) && isset($dados['nomeRazaoSocial']) && isset($dados['cpfCnpj']) && isset($dados['endereco']) && isset($dados['telefone'])) {
    // Prepare sua query de atualização
    $sql = "UPDATE clientes SET nome_razao_social = ?, cpf_cnpj = ?, endereco = ?, telefone = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            $dados['nomeRazaoSocial'],
            $dados['cpfCnpj'],
            $dados['endereco'],
            $dados['telefone'],
            $dados['clienteId']
        ]);
        echo json_encode(['sucesso' => true]);
    } catch (PDOException $e) {
        echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
}
