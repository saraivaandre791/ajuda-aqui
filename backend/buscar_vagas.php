<?php
session_start();
include("conexao.php");

// Captura filtros da pesquisa
$cidade = isset($_GET['cidade']) ? mysqli_real_escape_string($conn, $_GET['cidade']) : '';
$area   = isset($_GET['area']) ? mysqli_real_escape_string($conn, $_GET['area']) : '';

// Monta a query base (sem campo status)
$sql = "SELECT v.id, v.titulo, v.descricao, v.cidade, v.area, o.nome_ong
        FROM vaga v
        INNER JOIN login_ong o ON v.ong_id = o.id
        WHERE 1=1";

if ($cidade !== '') {
    $sql .= " AND v.cidade LIKE '%$cidade%'";
}
if ($area !== '') {
    $sql .= " AND v.area LIKE '%$area%'";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar vagas — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page arena-page--stack">
    <main class="arena-card arena-card--wide arena-card--grid" role="main">
        <header class="arena-list-head">
            <p class="arena-login-kicker">Área do candidato</p>
            <h2 class="arena-login-title">Buscar vagas</h2>
            <p class="arena-login-lead">Pesquise oportunidades por cidade e área de atuação.</p>
        </header>

        <!-- Formulário de pesquisa -->
        <form method="GET" action="buscar_vagas.php" class="arena-form">
            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" id="cidade" value="<?php echo htmlspecialchars($cidade); ?>">
            <br><br>

            <label for="area">Área de atuação:</label>
            <input type="text" name="area" id="area" value="<?php echo htmlspecialchars($area); ?>">
            <br><br><br>

            <button type="submit" class="arena-cta arena-cta--primary">Pesquisar</button>
        </form>

        <!-- Resultados -->
        <div class="card-container" style="margin-top:1.5rem">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($vaga = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
    <h3><?php echo htmlspecialchars($vaga['titulo']); ?></h3>
    <p><?php echo htmlspecialchars($vaga['descricao']); ?></p>
    <p><strong>Cidade:</strong> <?php echo htmlspecialchars($vaga['cidade']); ?></p>
    <p><strong>Área:</strong> <?php echo htmlspecialchars($vaga['area']); ?></p>
    <p><strong>ONG:</strong> <?php echo htmlspecialchars($vaga['nome_ong']); ?></p>
    <form action="candidatar.php" method="POST">
        <input type="hidden" name="idVaga" value="<?php echo $vaga['id']; ?>">
        <button type="submit" class="arena-cta arena-cta--primary">Quero participar</button>
    </form>
</div>

                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhuma vaga encontrada com esses critérios.</p>
            <?php endif; ?>
        </div>

        <div class="arena-actions" style="margin-top:1.5rem">
            <a href="perfil_candidato.php" class="arena-cta arena-cta--outline">Voltar ao perfil</a>
        </div>
    </main>
</body>
</html>
