<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['ong_id'])) {
    header("Location: login_ong.html");
    exit;
}

$id = intval($_SESSION['id']);
$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel da ONG</title>
    <link rel="stylesheet" href="/ajuda-aqui/frontend/css/arena.css">
</head>
<body>
    <h2>Painel da ONG</h2>

    <?php if ($row): ?>
        <div class="perfil-container">
            <h3><?php echo $row['nome_ong']; ?></h3>
            <p><strong>CNPJ:</strong> <?php echo $row['cnpj']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Telefone:</strong> <?php echo $row['telefone']; ?></p>
            <p><strong>Endereço:</strong> 
                <?php echo $row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']; ?>
            </p>
            <p><strong>Área de atuação:</strong> <?php echo $row['atuacao']; ?></p>
        </div>

        <br>
        <a href="../frontend/html/editar_ong.html">
            <button>Editar Informações</button></a>
            
        <a href="listar_candidatos.php">
            <button>Ver candidatos</button></a>
    <?php else: ?>
        <p>Dados da ONG não encontrados. Faça login novamente.</p>
    <?php endif; ?>

    
</body>
</html>