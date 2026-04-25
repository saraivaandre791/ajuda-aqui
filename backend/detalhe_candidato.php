<?php
session_start();
include("conexao.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT l.id, l.nome_candidato,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql);
$row = null;
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}

$endereco = '';
if ($row) {
    $endereco = trim(
        ($row['rua'] ?? '') . ', ' . ($row['numero'] ?? '') . ' — ' .
        ($row['cidade'] ?? '') . '/' . ($row['estado'] ?? '')
    );
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do candidato — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page">
    <main class="arena-card arena-card--profile" role="main">
        <div class="arena-brand">
            <img src="../frontend/logo/LOGO.jpg" alt="AjudAqui" class="arena-logo-sm" width="140">
        </div>
        <header class="arena-list-head">
            <p class="arena-login-kicker">Candidato</p>
            <h2 class="arena-login-title">Detalhes</h2>
        </header>

        <?php if ($row): ?>
            <dl class="arena-profile-dl">
                <dt>Nome</dt>
                <dd><?php echo htmlspecialchars($row['nome_candidato'] ?? ''); ?></dd>
                <dt>E-mail</dt>
                <dd><?php echo htmlspecialchars($row['email'] ?? ''); ?></dd>
                <dt>Telefone</dt>
                <dd><?php echo htmlspecialchars($row['telefone'] ?? ''); ?></dd>
                <dt>Endereço</dt>
                <dd><?php echo htmlspecialchars($endereco); ?></dd>
                <dt>CEP</dt>
                <dd><?php echo htmlspecialchars($row['cep'] ?? ''); ?></dd>
            </dl>
        <?php else: ?>
            <p class="arena-footnote" style="margin-top:0">Candidato não encontrado.</p>
        <?php endif; ?>

        <div class="arena-actions">
            <a href="listar_candidatos.php" class="arena-cta arena-cta--primary">Voltar à lista</a>
            <a href="painel_ong.php" class="arena-cta arena-cta--outline">Voltar ao painel</a>
        </div>
    </main>
</body>
</html>
