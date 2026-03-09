<?php
session_start(); // Inicia a sessão para acessar dados do candidato logado
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Verifica se o candidato está logado (se existe id na sessão)
// Caso contrário, redireciona para a página de login
if (!isset($_SESSION['id'])) {
    header("Location: login_candidato.html");
    exit;
}

// Recupera o ID do candidato logado a partir da sessão
//  Sugestão: padronizar para $_SESSION['candidato_id'] para evitar confusão com ONG
$id = intval($_SESSION['id']);

// Consulta SQL para buscar os dados do candidato logado
// Junta informações de login, contato e endereço usando LEFT JOIN
$sql = "SELECT l.id, l.nome_candidato, l.login,
            c.telefone, c.email,
            e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id             
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id 
        WHERE l.id = $id";     

$result = mysqli_query($conn, $sql); // Executa a consulta
$row = mysqli_fetch_assoc($result); // Pega os dados do candidato
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
     <meta charset="UTF-8"> <!-- Define o padrão de caracteres -->
     <title>Perfil do Candidato</title> <!-- Título da aba do navegador -->
     <link rel="stylesheet" href="/ajuda-aqui/frontend/css/arena.css"> <!-- Importa o CSS -->
</head>
<body>
     <div class="perfil-container"> 
        <h2>Perfil do Candidato</h2> <!-- Cabeçalho principal da página -->
    
    <?php if ($row): ?>
         <!-- Exibe os dados do candidato logado -->
         <div class="info"><strong>Nome:</strong> <?php echo $row['nome_candidato']; ?></div>
         <div class="info"><strong>Login:</strong> <?php echo $row['login']; ?></div>
         <div class="info"><strong>Telefone:</strong> <?php echo $row['telefone']; ?></div>
         <div class="info"><strong>Email:</strong> <?php echo $row['email']; ?></div>
         <div class="info"><strong>Endereço:</strong> 
            <?php echo $row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']; ?>
         </div>
         <div class="info"><strong>CEP:</strong> <?php echo $row['cep']; ?></div><br>

         <!-- Botões de ação: editar informações ou ver ONGs cadastradas -->
         <div class="actions">
            <a href="../frontend/html/editar_candidato.html">
                <button>Editar Informações</button>
            </a>
            <a href="../backend/listar_ongs.php">
                <button>Ver ONGs</button>
            </a>
         </div>
    <?php else: ?>
        <!-- Caso não encontre dados do candidato -->
        <p>Nenhum candidato encontrado. Faça login novamente.</p>
    <?php endif; ?>
     </div>
</body>
</html>