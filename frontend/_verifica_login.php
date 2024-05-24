<?php
session_start(); // Inicia a sessão

// Verifica se a variável de sessão 'usuario_id' NÃO está definida
if (!isset($_SESSION['usuario_id'])) {
    // Usuário não está logado, redireciona para login.php
    header('Location: login.php');
    exit; // Impede a execução de qualquer código seguinte
}
// O resto do seu código aqui, que será executado apenas se o usuário estiver logado
?>
