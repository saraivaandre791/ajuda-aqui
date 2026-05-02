<?php
session_start();
include("conexao.php");

$login = $_POST['login'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "SELECT * FROM logins WHERE login='$login' AND senha='$senha'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $row['id'];
    $_SESSION['tipo'] = "candidato";
    $_SESSION['login'] = $row['login'];
    header("Location: perfil_candidato.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page">

 <!-- Botão voltar para index -->
    <div style="position:absolute; top:15px; right:15px;">
    <a href="../frontend/html/index.html" class="arena-cta arena-cta--outline">Início</a>
</div>

    <main class="arena-card arena-card--form" role="main">
        <div class="arena-brand">
            <img src="../frontend/logo/LOGO.jpg" alt="AjudAqui" class="arena-logo-sm" width="140">
        </div>
        <header class="arena-login-head">
            <p class="arena-login-kicker">Área do candidato</p>
            <h2 class="arena-login-title">Não foi possível entrar</h2>
            <p class="arena-login-lead">Usuário ou senha inválidos. Confira os dados e tente novamente.</p>
        </header>
        <div class="arena-actions">
            <a href="../frontend/html/login_candidato.html" class="arena-cta arena-cta--primary">Voltar ao login</a>
        </div>
    </main>
</body>
</html>
