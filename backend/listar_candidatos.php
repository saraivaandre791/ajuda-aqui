<?php
session_start();
include("conexao.php");

$sql = "SELECT l.id, l.nome_candidato,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page arena-page--stack">
    <main class="arena-card arena-card--wide arena-card--grid" role="main">
        <header class="arena-list-head">
            <p class="arena-login-kicker">ONG</p>
            <h2 class="arena-login-title">Candidatos registrados</h2>
        </header>

        <div class="card-container">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                    $idCand = (int) $row['id'];
                    $end = trim(
                        ($row['rua'] ?? '') . ', ' . ($row['numero'] ?? '') . ' — ' .
                        ($row['cidade'] ?? '') . '/' . ($row['estado'] ?? '') . ' — CEP ' . ($row['cep'] ?? '')
                    );
                    ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($row['nome_candidato'] ?? ''); ?></h3>
                        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($row['email'] ?? ''); ?></p>
                        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($row['telefone'] ?? ''); ?></p>
                        <p><strong>Endereço:</strong> <?php echo htmlspecialchars($end); ?></p>
                        <a href="detalhe_candidato.php?id=<?php echo $idCand; ?>" class="arena-cta arena-cta--primary">Ver detalhes</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum candidato cadastrado.</p>
            <?php endif; ?>
        </div>

        <div class="arena-actions" style="margin-top:1.5rem">
            <a href="painel_ong.php" class="arena-cta arena-cta--outline">Voltar ao painel</a>
        </div>
    </main>
</body>
</html>
