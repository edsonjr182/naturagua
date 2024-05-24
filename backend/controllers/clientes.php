<?php
// Inclui o arquivo de conexão com o banco de dados
require_once '../config/conn.php';

// Prepara a consulta SQL para buscar todos os clientes
$sql = "SELECT nome_razao_social, telefone FROM clientes";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Busca os resultados
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define o cabeçalho para retornar JSON
header('Content-Type: application/json');
// Retorna os dados em formato JSON
echo json_encode($clientes);
