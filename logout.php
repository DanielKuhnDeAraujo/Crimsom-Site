<?php
// Inicia a sessão para poder acessá-la
session_start();

// Destrói todas as variáveis de sessão
session_unset();

// Destrói a sessão no servidor
session_destroy();

// Redireciona o usuário de volta para a tela de login
header("Location: index.php");
exit();
?>
