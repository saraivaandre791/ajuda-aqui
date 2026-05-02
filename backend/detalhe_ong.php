<?php
session_start();
include("conexao.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Dados da ONG
$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id
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

// Vagas da ONG
$sqlVagas = "SELECT id, titulo, descricao, cidade, area 
             FROM vaga 
             WHERE ong_id = $id";
$resultVagas = mysqli_query($conn, $sqlVagas);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da ONG — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page">
    <main class="arena-card arena-card--profile" role="main">
        <div class="arena-brand">
            <img src="../frontend/logo/LOGO.jpg" alt="AjudAqui" class="arena-logo-sm" width="140">
        </div>
        <header class="arena-list-head">
            <p class="arena-login-kicker">ONG</p>
            <h2 class="arena-login-title">Detalhes</h2>
        </header>

        <?php if ($row): ?>
            <dl class="arena-profile-dl">
                <dt>Nome</dt>
                <dd><?php echo htmlspecialchars($row['nome_ong'] ?? ''); ?></dd>
                <dt>CNPJ</dt>
                <dd><?php echo htmlspecialchars($row['cnpj'] ?? ''); ?></dd>
                <dt>Área de atuação</dt>
                <dd><?php echo htmlspecialchars($row['atuacao'] ?? ''); ?></dd>
                <dt>E-mail</dt>
                <dd><?php echo htmlspecialchars($row['email'] ?? ''); ?></dd>
                <dt>Telefone</dt>
                <dd><?php echo htmlspecialchars($row['telefone'] ?? ''); ?></dd>
                <dt>Endereço</dt>
                <dd><?php echo htmlspecialchars($endereco); ?></dd>
                <dt>CEP</dt>
                <dd><?php echo htmlspecialchars($row['cep'] ?? ''); ?></dd>
            </dl>

            <!-- Listagem de vagas -->
            <h3>Vagas disponíveis</h3>
            <div class="card-container">
                <?php if ($resultVagas && mysqli_num_rows($resultVagas) > 0): ?>
                    <?php while ($vaga = mysqli_fetch_assoc($resultVagas)): ?>
                        <div class="card">
                            <h4><?php echo htmlspecialchars($vaga['titulo']); ?></h4>
                            <p><?php echo htmlspecialchars($vaga['descricao']); ?></p>
                            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($vaga['cidade']); ?></p>
                            <p><strong>Área:</strong> <?php echo htmlspecialchars($vaga['area']); ?></p>
                            <form action="candidatar.php" method="POST">
    <input type="hidden" name="idVaga" value="<?php echo $vaga['id']; ?>">
    <button type="submit" 
            id="btnParticipar_<?php echo $vaga['id']; ?>" 
            class="arena-cta arena-cta--primary">
        Quero participar
    </button>
</form>

                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhuma vaga publicada por esta ONG.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="arena-footnote" style="margin-top:0">ONG não encontrada.</p>
        <?php endif; ?>

        <div class="arena-actions">
            <a href="listar_ongs.php" class="arena-cta arena-cta--primary">Voltar à lista</a>
            <a href="perfil_candidato.php" class="arena-cta arena-cta--outline">Voltar ao perfil</a>
        </div>
    </main>
</body>
</html>
