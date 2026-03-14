<?php
session_start();
session_unset();
session_destroy();

// Redireciona para a tela de login da ONG
header("Location: /ajuda-aqui/frontend/html/login_ong.html");
exit;
?>