<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id'])) {
    header("Location: login_candidato.html");
    exit;
}

$id = intval($_SESSION['id']);

$sql = "SELECT l.id, l.nome_candidato, l.login,
            c.telefone, c.email,
            e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AjudAqui</title>
    <link rel="stylesheet" href="/ajuda-aqui/frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="/ajuda-aqui/frontend/static/abobora.ico"/>
</head>
<body class="arena-page">
    <main class="arena-card arena-card--profile" role="main">
        <div class="arena-brand">
            <img src="/ajuda-aqui/frontend/logo/LOGO.jpg" alt="AjudAqui" class="arena-logo-sm" width="140">
        </div>
        <h2>Perfil do candidato</h2>

        <?php if ($row): ?>
            <dl class="arena-profile-dl">
                <dt>Nome</dt>
                <dd><?php echo htmlspecialchars($row['nome_candidato']); ?></dd>
                <dt>Login</dt>
                <dd><?php echo htmlspecialchars($row['login']); ?></dd>
                <dt>Telefone</dt>
                <dd><?php echo htmlspecialchars($row['telefone']); ?></dd>
                <dt>E-mail</dt>
                <dd><?php echo htmlspecialchars($row['email']); ?></dd>
                <dt>Endereço</dt>
                <dd><?php echo htmlspecialchars(trim($row['rua'] . ', ' . $row['numero'] . ' - ' . $row['cidade'] . '/' . $row['estado'])); ?></dd>
                <dt>CEP</dt>
                <dd><?php echo htmlspecialchars($row['cep']); ?></dd>
            </dl>

            <div class="arena-actions">
                <a href="../frontend/html/editar_candidato.html" class="arena-cta arena-cta--primary">Editar informações</a>
                <a href="listar_ongs.php" class="arena-cta arena-cta--outline">Ver ONGs</a>
                <a href="logout.php" class="arena-cta arena-cta--outline">Sair</a>
            </div>
        <?php else: ?>
            <p class="arena-footnote" style="margin-top:0">Nenhum candidato encontrado. Faça login novamente.</p>
        <?php endif; ?>
    </main>
</body>
</html>
