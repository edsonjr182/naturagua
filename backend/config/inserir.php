<?php
require_once 'conn.php'; // Ajuste o caminho conforme necessário

// Informações do usuário administrador
$emailAdmin = "admin@example.com";
$senhaAdmin = password_hash("senhaAdmin123", PASSWORD_DEFAULT); // Substitua pela senha desejada
$nivelAcessoAdmin = 1; // Nível de acesso para administrador

// Informações do usuário comum
$emailComum = "usuario@example.com";
$senhaComum = password_hash("senhaUsuario123", PASSWORD_DEFAULT); // Substitua pela senha desejada
$nivelAcessoComum = 2; // Nível de acesso para usuário comum

// Preparando a query SQL
$sql = "INSERT INTO usuarios (email, senha, nivel_acesso) VALUES (:email, :senha, :nivel_acesso)";

// Inserindo o usuário administrador
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':email' => $emailAdmin,
    ':senha' => $senhaAdmin,
    ':nivel_acesso' => $nivelAcessoAdmin
]);

// Inserindo o usuário comum
$stmt->execute([
    ':email' => $emailComum,
    ':senha' => $senhaComum,
    ':nivel_acesso' => $nivelAcessoComum
]);

echo "Usuários inseridos com sucesso!";
?>
