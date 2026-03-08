<?php
session_start();
include("conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login_candidato.html");
    exit;
}

$id = intval($_SESSION['id']); // pega o id do candidato logado



$sql = "SELECT l.id, l.nome_candidato, l.login,
            c.telefone, c.email,
            e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id             
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id 
        WHERE l.id = $id";     

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
     <meta charset="UTF-8">
     <title>Perfil do Candidato</title>
     <link rel="stylesheet" href="/ajuda-aqui/frontend/css/arena.css">
</head>
<body>
     <div class="perfil-container"> 
        <h2>Perfil do Candidato</h2>
    
    <?php if ($row): ?>
         <div class="info"><strong>Nome:</strong> <?php echo $row['nome_candidato']; ?></div>
         <div class="info"><strong>Login:</strong> <?php echo $row['login']; ?></div>
         <div class="info"><strong>Telefone:</strong> <?php echo $row['telefone']; ?></div>
         <div class="info"><strong>Email:</strong> <?php echo $row['email']; ?></div>
         <div class="info"><strong>Endereço:</strong> 
            <?php echo $row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']; ?>
         </div>
         <div class="info"><strong>CEP:</strong> <?php echo $row['cep']; ?></div><br>

         <div class="actions">
            <a href="../frontend/html/editar_candidato.html">
                <button>Editar Informações</button>
            </a>
            <a href="../backend/listar_ongs.php">
                <button>Ver ONGs</button>
            </a>
         </div>
    <?php else: ?>
        <p>Nenhum candidato encontrado. Faça login novamente.</p>
    <?php endif; ?>
     </div>
            

</body>