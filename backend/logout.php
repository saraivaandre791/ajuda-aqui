<?php
session_start();
session_unset();
session_destroy();
header("Location: ../frontend/html/login_candidato.html");
exit;
?>