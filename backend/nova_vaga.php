<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['ong_id'])) {
    header("Location: ../frontend/html/login_ong.html");
    exit;
}

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $ong_id = intval($_SESSION['ong_id']);

    $sql = "INSERT INTO vaga (titulo, descricao, cidade, area, ong_id)
            VALUES ('$titulo', '$descricao', '$cidade', '$area', '$ong_id')";

    if (mysqli_query($conn, $sql)) {
        $mensagem = "Vaga criada com sucesso!";
    } else {
        $mensagem = "Erro ao criar vaga: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar nova vaga — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page">
    <main class="arena-card arena-card--profile" role="main">
        <div class="arena-brand">
            <img src="../frontend/logo/LOGO.jpg" alt="AjudAqui" class="arena-logo-sm" width="140">
        </div>
        <header class="arena-list-head">
            <p class="arena-login-kicker">Área da ONG</p>
            <h2 class="arena-login-title">Criar nova vaga</h2>
            <p class="arena-login-lead">Preencha os dados da oportunidade.</p>
        </header>

        <?php if (!empty($mensagem)): ?>
            <p class="arena-footnote"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <form method="POST" class="arena-form">
            <label for="titulo">Título da vaga</label>
            <input type="text" id="titulo" name="titulo" required>
            <br><br>

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>
            <br><br>

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" required>
            <br><br>

            <label for="area">Área de interesse</label>
            <input type="text" id="area" name="area" required>

            <div class="arena-actions" style="margin-top:1.5rem">
                <button type="submit" class="arena-cta arena-cta--primary">Salvar vaga</button>
                <a href="painel_ong.php" class="arena-cta arena-cta--outline">Voltar ao painel</a>
            </div>
        </form>
    </main>
</body>
</html>
