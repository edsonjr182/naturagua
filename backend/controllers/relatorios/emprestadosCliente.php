<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';

$db   = '';
$user = '';
$pass = '';

$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $sql = "SELECT 
                c.nome_razao_social AS Cliente,
                p.tipo AS Tipo_de_produto,
                SUM(e.quantidade - e.devolvido) AS Quantidade_em_comodato,
                SUM((e.quantidade - e.devolvido) * p.valor_custo) AS Custo_total
            FROM 
                emprestimo e
            JOIN 
                clientes c ON e.cliente = c.id
            JOIN 
                produtos p ON e.produto = p.id
            WHERE 
                e.status = 0 AND (e.quantidade - e.devolvido) > 0
            GROUP BY 
                c.nome_razao_social, p.tipo
            ORDER BY 
                c.nome_razao_social, p.tipo";
    $stmt = $pdo->query($sql);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
} catch (\PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
