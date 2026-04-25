<?php
session_start();
include("conexao.php");

$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
                c.telefone, c.email,
                e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONGs — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
    <link rel="shortcut icon" type="image/svg" href="../frontend/static/abobora.ico"/>
</head>
<body class="arena-page arena-page--stack">
    <main class="arena-card arena-card--wide arena-card--grid" role="main">
        <header class="arena-list-head">
            <p class="arena-login-kicker">Candidato</p>
            <h2 class="arena-login-title">ONGs registradas</h2>
        </header>

        <div class="card-container">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                    $idOng = (int) $row['id'];
                    $end = trim(
                        ($row['rua'] ?? '') . ', ' . ($row['numero'] ?? '') . ' — ' .
                        ($row['cidade'] ?? '') . '/' . ($row['estado'] ?? '') . ' — CEP ' . ($row['cep'] ?? '')
                    );
                    ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($row['nome_ong'] ?? ''); ?></h3>
                        <p><strong>CNPJ:</strong> <?php echo htmlspecialchars($row['cnpj'] ?? ''); ?></p>
                        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($row['email'] ?? ''); ?></p>
                        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($row['telefone'] ?? ''); ?></p>
                        <p><strong>Endereço:</strong> <?php echo htmlspecialchars($end); ?></p>
                        <a href="detalhe_ong.php?id=<?php echo $idOng; ?>" class="arena-cta arena-cta--primary">Ver detalhes</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhuma ONG cadastrada.</p>
            <?php endif; ?>
        </div>

        <div class="arena-actions" style="margin-top:1.5rem">
            <a href="perfil_candidato.php" class="arena-cta arena-cta--outline">Voltar ao perfil</a>
        </div>
    </main>
</body>
</html>
