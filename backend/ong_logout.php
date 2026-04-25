<?php
session_start();
session_unset();
session_destroy();

// Redireciona para a tela de login da ONG
header("Location: ../frontend/html/login_ong.html");
exit;
?>