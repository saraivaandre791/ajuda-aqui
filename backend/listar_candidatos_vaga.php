<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['ong_id'])) {
    header("Location: ../frontend/html/login_ong.html");
    exit;
}

$ong_id = intval($_SESSION['ong_id']);

// Consulta vagas e candidatos inscritos
$sql = "SELECT v.id AS vaga_id, v.titulo, v.cidade, v.area,
               c.id AS candidato_id, c.nome_candidato, cc.telefone, cc.email
        FROM vaga v
        LEFT JOIN candidatura cd ON v.id = cd.vaga_id
        LEFT JOIN logins c ON cd.candidato_id = c.id
        LEFT JOIN contato_candidato cc ON c.id = cc.candidato_id
        WHERE v.ong_id = $ong_id
        ORDER BY v.id DESC";

$result = mysqli_query($conn, $sql);

$vagas = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $vagaId = $row['vaga_id'];
        if (!isset($vagas[$vagaId])) {
            $vagas[$vagaId] = [
                'titulo' => $row['titulo'],
                'cidade' => $row['cidade'],
                'area' => $row['area'],
                'candidatos' => []
            ];
        }
        if ($row['candidato_id']) {
            $vagas[$vagaId]['candidatos'][] = [
                'nome' => $row['nome_candidato'],
                'email' => $row['email'],
                'telefone' => $row['telefone']
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos inscritos — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page arena-page--stack">
    <main class="arena-card arena-card--wide arena-card--grid" role="main">
        <header class="arena-list-head">
            <p class="arena-login-kicker">Área da ONG</p>
            <h2 class="arena-login-title">Candidatos inscritos nas vagas</h2>
        </header>

        <div class="card-container">
            <?php if (!empty($vagas)): ?>
                <?php foreach ($vagas as $vagaId => $vaga): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($vaga['titulo']); ?></h3>
                        <p><strong>Cidade:</strong> <?php echo htmlspecialchars($vaga['cidade']); ?></p>
                        <p><strong>Área:</strong> <?php echo htmlspecialchars($vaga['area']); ?></p>

                        <?php if (!empty($vaga['candidatos'])): ?>
                            <h4>Candidatos:</h4>
                            <ul>
                                <?php foreach ($vaga['candidatos'] as $cand): ?>
                                    <li>
                                        <?php echo htmlspecialchars($cand['nome']); ?> —
                                        <?php echo htmlspecialchars($cand['email']); ?> —
                                        <?php echo htmlspecialchars($cand['telefone']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Nenhum candidato inscrito nesta vaga.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma vaga publicada ainda.</p>
            <?php endif; ?>
        </div>

        <div class="arena-actions" style="margin-top:1.5rem">
            <a href="painel_ong.php" class="arena-cta arena-cta--outline">Voltar ao painel</a>

        </div>
    </main>
</body>
</html>
