<?php
require_once '../config/conn.php'; // Certifique-se de ajustar o caminho conforme necessário

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

// Validação básica para garantir que todos os campos necessários estão presentes
if(isset($dados['nomeRazaoSocial'], $dados['cpfCnpj'], $dados['endereco'], $dados['telefone'])) {
    try {
        $sql = "INSERT INTO clientes (nome_razao_social, cpf_cnpj, endereco, telefone) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['nomeRazaoSocial'],
            $dados['cpfCnpj'],
            $dados['endereco'],
            $dados['telefone']
        ]);

        // Retorna sucesso
        echo json_encode(['sucesso' => true, 'mensagem' => 'Cliente adicionado com sucesso.']);
    } catch (PDOException $e) {
        // Retorna erro se algo der errado
        http_response_code(500);
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao adicionar o cliente: ' . $e->getMessage()]);
    }
} else {
    // Retorna erro se algum campo estiver faltando
    echo json_encode(['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.']);
}
