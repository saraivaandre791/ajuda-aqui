<?php
session_start();
include("conexao.php");

// Verifica se o candidato está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../frontend/html/login_candidato.html");
    exit;
}

$idCandidato = intval($_SESSION['id']);
$idVaga = isset($_POST['idVaga']) ? intval($_POST['idVaga']) : 0;

$mensagem = "";

if ($idVaga > 0) {
    // Verifica se já existe candidatura para essa vaga
    $sqlCheck = "SELECT * FROM candidatura WHERE candidato_id='$idCandidato' AND vaga_id='$idVaga'";
    $resultCheck = mysqli_query($conn, $sqlCheck);

    if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
        $mensagem = "Você já está inscrito nesta vaga.";
    } else {
        // Se não existe, insere nova candidatura
        $sql = "INSERT INTO candidatura (candidato_id, vaga_id, data_candidatura)
                VALUES ('$idCandidato', '$idVaga', NOW())";

        if (mysqli_query($conn, $sql)) {
            $mensagem = "Candidatura registrada com sucesso!";
        } else {
            $mensagem = "Erro ao registrar candidatura: " . mysqli_error($conn);
        }
    }
} else {
    $mensagem = "Vaga inválida.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatar-se — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page">
    <main class="arena-card arena-card--profile" role="main">
        <div class="arena-brand">
            <img src="../frontend/logo/LOGO.jpg" alt="AjudAqui" class="arena-logo-sm" width="140">
        </div>
        <header class="arena-list-head">
            <p class="arena-login-kicker">Candidatura</p>
            <h2 class="arena-login-title">Resultado</h2>
        </header>

        <p class="arena-footnote"><?php echo htmlspecialchars($mensagem); ?></p>

        <div class="arena-actions">
            <a href="perfil_candidato.php" class="arena-cta arena-cta--primary">Voltar ao perfil</a>
            <a href="listar_ongs.php" class="arena-cta arena-cta--outline">Ver outras ONGs</a>
        </div>
    </main>
</body>
</html>
