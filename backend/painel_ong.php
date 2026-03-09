<?php
session_start(); // Inicia a sessão para acessar dados da ONG logada
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Verifica se a ONG está logada (se existe ong_id na sessão)
// Caso contrário, redireciona para a página de login
if (!isset($_SESSION['ong_id'])) {
    header("Location: login_ong.html");
    exit;
}

// Recupera o ID da ONG logada a partir da sessão
//  Aqui está usando $_SESSION['id'], mas o ideal é padronizar para $_SESSION['ong_id']
$id = intval($_SESSION['id']);

// Consulta SQL para buscar os dados da ONG logada
// Junta informações de login, contato e endereço usando LEFT JOIN
$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql); // Executa a consulta
$row = mysqli_fetch_assoc($result); // Pega os dados da ONG
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define o padrão de caracteres -->
    <title>Painel da ONG</title> <!-- Título da aba do navegador -->
    <link rel="stylesheet" href="/ajuda-aqui/frontend/css/arena.css"> <!-- Importa o CSS -->
</head>
<body>
    <h2>Painel da ONG</h2> <!-- Cabeçalho principal da página -->

    <?php if ($row): ?>
        <!-- Exibe os dados da ONG logada -->
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
        <!-- Botão para editar informações da ONG -->
        <a href="../frontend/html/editar_ong.html">
            <button>Editar Informações</button></a>
            
        <!-- Botão para visualizar candidatos cadastrados -->
        <a href="listar_candidatos.php">
            <button>Ver candidatos</button></a>
    <?php else: ?>
        <!-- Caso não encontre dados da ONG -->
        <p>Dados da ONG não encontrados. Faça login novamente.</p>
    <?php endif; ?>

</body>
</html>