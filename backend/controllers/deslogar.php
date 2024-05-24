<?php
session_start(); // Inicia a sessão

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se é desejado destruir a sessão completamente, remova também o cookie de sessão.
// Isso irá destruir a sessão, e não apenas os dados de sessão!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrua a sessão.
session_destroy();

// Redireciona para a tela de login
header("Location: ../../frontend/login.php");
exit;
?>
