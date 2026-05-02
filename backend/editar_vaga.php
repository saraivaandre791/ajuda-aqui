<?php
session_start();
include("conexao.php");

// Verifica se a ONG está logada
if (!isset($_SESSION['ong_id'])) {
    header("Location: ../frontend/html/login_ong.html");
    exit;
}

$ongId = intval($_SESSION['ong_id']);
$idVaga = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($idVaga <= 0) {
    echo "Vaga inválida.";
    exit;
}

// Busca dados da vaga
$sql = "SELECT * FROM vaga WHERE id = $idVaga AND ong_id = $ongId";
$result = mysqli_query($conn, $sql);
$vaga = mysqli_fetch_assoc($result);

if (!$vaga) {
    echo "Vaga não encontrada ou não pertence a esta ONG.";
    exit;
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);

    $sqlUpdate = "UPDATE vaga 
                  SET titulo='$titulo', descricao='$descricao', cidade='$cidade', area='$area'
                  WHERE id=$idVaga AND ong_id=$ongId";

    if (mysqli_query($conn, $sqlUpdate)) {
        $mensagem = "Vaga atualizada com sucesso!";
    } else {
        $mensagem = "Erro ao atualizar: " . mysqli_error($conn);
    }

    // Recarrega os dados atualizados
    $result = mysqli_query($conn, "SELECT * FROM vaga WHERE id = $idVaga AND ong_id = $ongId");
    $vaga = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar vaga — AjudAqui</title>
    <link rel="stylesheet" href="../frontend/css/arena.css">
</head>
<body class="arena-page">
    <main class="arena-card arena-card--profile" role="main">
        <header class="arena-list-head">
            <p class="arena-login-kicker">Área da ONG</p>
            <h2 class="arena-login-title">Editar vaga</h2>
        </header>

        <?php if (!empty($mensagem)): ?>
            <p class="arena-footnote"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>

        <form method="POST" class="arena-form">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($vaga['titulo']); ?>" required><br><br>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required><?php echo htmlspecialchars($vaga['descricao']); ?></textarea><br><br>

            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" id="cidade" value="<?php echo htmlspecialchars($vaga['cidade']); ?>" required><br><br>

            <label for="area">Área:</label>
            <input type="text" name="area" id="area" value="<?php echo htmlspecialchars($vaga['area']); ?>" required><br><br>

            <button type="submit" class="arena-cta arena-cta--primary">Salvar alterações</button>
            <a href="painel_ong.php" class="arena-cta arena-cta--outline">Voltar</a>
        </form>
    </main>
</body>
</html>
