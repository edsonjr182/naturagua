<?php
session_start();
require_once '../config/conn.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!empty($email) && !empty($senha)) {
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Armazenar informações do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_nivel_acesso'] = $usuario['nivel_acesso'];
        // Redirecionar para a página inicial do sistema
        header('Location: ../../frontend/painel.php');
        exit;
    } else {
        // Falha no login, redirecionar de volta para a tela de login com erro
        header('Location: ../../login.php?erro=1');
        exit;
    }
} else {
    // Campos não preenchidos
    header('Location: ../../login.php?erro=2');
    exit;
}
?>
