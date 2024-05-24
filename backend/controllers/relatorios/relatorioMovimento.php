<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);


$host = 'localhost';
$db   = 'u122714473_naturagua';
$user = 'u122714473_naturagua';
$pass = 'Morbidus@2938'; // Por segurança, garanta que a senha seja gerenciada de forma segura.
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Capturando parâmetros da URL
$tipoTransacao = $_GET['tipoTransacao'];
$dataInicio = new DateTime();
$dataFim = new DateTime();

// Ajuste de datas conforme o intervalo desejado
switch ($_GET['intervalo']) {
    case '7dias':
        $dataInicio->modify('-7 days');
        break;
    case '15dias':
        $dataInicio->modify('-15 days');
        break;
    case 'mensal':
        $dataInicio->modify('-1 month');
        break;
    case 'anual':
        $dataInicio->modify('-1 year');
        break;
}

$sql = "SELECT 
    t.data_transacao AS Data,
    t.tipo_transacao AS Tipo_de_Transacao,
    COALESCE(c.nome_razao_social, ' ') AS Nome_Cliente,
    p.descricao AS Nome_Produto,
    t.quantidade AS Quantidade
FROM 
    transacoes t
LEFT JOIN 
    clientes c ON t.cliente_id = c.id
JOIN 
    produtos p ON t.produto_id = p.id
WHERE 
    t.data_transacao >= :dataInicio AND
    t.data_transacao <= :dataFim";

// Incluir tipo de transação apenas se não for 'todos'
if ($tipoTransacao != 'todos') {
    $sql .= " AND t.tipo_transacao = :tipoTransacao";
}

$sql .= " ORDER BY t.data_transacao DESC";

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $stmt = $pdo->prepare($sql);
    $params = ['dataInicio' => $dataInicio->format('Y-m-d H:i:s'), 'dataFim' => $dataFim->format('Y-m-d H:i:s')];

    // Adicionar tipoTransacao ao array de parâmetros se não for 'todos'
    if ($tipoTransacao != 'todos') {
        $params['tipoTransacao'] = $tipoTransacao;
    }

    $stmt->execute($params);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

?>
