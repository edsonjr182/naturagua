<?php
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $nivel_acesso = $_POST['nivel_acesso'];

    $sql = "INSERT INTO usuarios (email, senha, nivel_acesso) VALUES (:email, :senha, :nivel_acesso)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'senha' => $senha, 'nivel_acesso' => $nivel_acesso]);

    header('Location: ../../frontend/pages/login.php');
    exit;
}
?>
