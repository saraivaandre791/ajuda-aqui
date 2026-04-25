<?php
session_start(); // Inicia a sessão para acessar dados da ONG logada
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

if (!isset($_SESSION['ong_id'])) {
    header("Location: ../frontend/html/login_ong.html");
    exit;
}

$id = intval($_SESSION['ong_id']);

$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

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
    <title>Painel da ONG — AjudAqui</title>
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
            <h2 class="arena-login-title">Painel</h2>
            <p class="arena-login-lead">Dados da sua organização nesta sessão.</p>
        </header>

        <?php if ($row): ?>
            <dl class="arena-profile-dl">
                <dt>Nome da ONG</dt>
                <dd><?php echo htmlspecialchars($row['nome_ong'] ?? ''); ?></dd>
                <dt>CNPJ</dt>
                <dd><?php echo htmlspecialchars($row['cnpj'] ?? ''); ?></dd>
                <dt>E-mail</dt>
                <dd><?php echo htmlspecialchars($row['email'] ?? ''); ?></dd>
                <dt>Telefone</dt>
                <dd><?php echo htmlspecialchars($row['telefone'] ?? ''); ?></dd>
                <dt>Endereço</dt>
                <dd><?php echo htmlspecialchars($endereco); ?></dd>
                <dt>CEP</dt>
                <dd><?php echo htmlspecialchars($row['cep'] ?? ''); ?></dd>
                <dt>Área de atuação</dt>
                <dd><?php echo htmlspecialchars($row['atuacao'] ?? ''); ?></dd>
            </dl>

            <div class="arena-actions">
                <a href="../frontend/html/editar_ong.html" class="arena-cta arena-cta--primary">Editar informações</a>
                <a href="listar_candidatos.php" class="arena-cta arena-cta--outline">Ver candidatos</a>
                <a href="ong_logout.php" class="arena-cta arena-cta--outline">Sair</a>
            </div>
        <?php else: ?>
            <p class="arena-footnote" style="margin-top:0">Dados da ONG não encontrados. Faça login novamente.</p>
            <div class="arena-actions">
                <a href="../frontend/html/login_ong.html" class="arena-cta arena-cta--primary">Ir para o login</a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
