<?php
session_start();
include("conexao.php");

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

// Consulta vagas da ONG logada
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

            <!-- Listagem de vagas publicadas -->
            <h3>Vagas publicadas</h3>
            <div class="card-container">
                <?php if ($resultVagas && mysqli_num_rows($resultVagas) > 0): ?>
                    <?php while ($vaga = mysqli_fetch_assoc($resultVagas)): ?>
                        <div class="card">
                            <h4><?php echo htmlspecialchars($vaga['titulo']); ?></h4>
                            <p><?php echo htmlspecialchars($vaga['descricao']); ?></p>
                            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($vaga['cidade']); ?></p>
                            <p><strong>Área:</strong> <?php echo htmlspecialchars($vaga['area']); ?></p>
                            <div class="arena-actions">
                                <a href="editar_vaga.php?id=<?php echo $vaga['id']; ?>" class="arena-cta arena-cta--primary">Editar</a>
                                <a href="excluir_vaga.php?id=<?php echo $vaga['id']; ?>" class="arena-cta arena-cta--outline">Excluir</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhuma vaga publicada ainda.</p>
                <?php endif; ?>
            </div>

            <div class="arena-actions" style="margin-top:1.5rem">
                <a href="nova_vaga.php" class="arena-cta arena-cta--primary">Criar nova vaga</a>
            </div>

            <div class="arena-actions">
                <a href="../frontend/html/editar_ong.html" class="arena-cta arena-cta--primary">Editar informações</a>
                <a href="listar_candidatos.php" class="arena-cta arena-cta--outline">Ver todos os candidatos</a>
                <a href="listar_candidatos_vaga.php" class="arena-cta arena-cta--outline">Ver candidatos inscritos nas vagas</a>
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
