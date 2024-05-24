<?php
$host = 'localhost';
$db   = 'u546883730_naturagua';
$user = 'u546883730_naturagua';
$pass = 'Ramunatra@2025';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sql = "SELECT clientes.nome_razao_social, SUM(transacoes.quantidade) AS quantidade_total
        FROM transacoes 
        JOIN clientes ON transacoes.cliente_id = clientes.id 
        WHERE transacoes.tipo_transacao = 'comodato' 
        GROUP BY clientes.nome_razao_social";
$stmt = $pdo->query($sql);
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($resultado);
