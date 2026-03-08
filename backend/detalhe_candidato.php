<?php
session_start();
include("conexao.php");

// Pega o ID do candidato pela URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT l.id, l.nome_candidato,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql);

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Detalhes do Candidato</title>
    <link rel='stylesheet' href='/ajuda-aqui/frontend/css/arena.css'>
</head>
<body>
    <h2>Detalhes do Candidato</h2>";

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    echo "<div class='perfil-container'>
            <h3>".$row['nome_candidato']."</h3>
            <p><strong>Email:</strong> ".$row['email']."</p>
            <p><strong>Telefone:</strong> ".$row['telefone']."</p>
            <p><strong>Endereço:</strong> ".$row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']."</p>
        </div>";
} else {
    echo "<p>Candidato não encontrado.</p>";
}

echo "<br>
      <a href='listar_candidatos.php'><button>Voltar à lista</button></a>
      <a href='painel_ong.php'><button>Voltar ao Painel</button></a>
</body>
</html>";
?>