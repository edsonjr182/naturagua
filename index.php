<?php
session_start();

// Verifica se o usuário está logado.
// Isso assume que você define uma variável de sessão durante o login.
if (isset($_SESSION['usuario_id'])) {
    // Se o usuário está logado, redirecione para a página inicial do sistema.
    header('Location: /frontend/painel.php');
    exit;
} else {
    // Se o usuário não está logado, redirecione para a tela de login.
    header('Location: ../frontend/login.php');
    exit;
}
?>
