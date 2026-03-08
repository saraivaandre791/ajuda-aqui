<?php
session_start();
include("conexao.php");

// Pega o ID da ONG pela URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql);

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Detalhes da ONG</title>
    <link rel='stylesheet' href='/ajuda-aqui/frontend/css/arena.css'>
</head>
<body>
    <h2>Detalhes da ONG</h2>";

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    echo "<div class='perfil-container'>
            <h3>".$row['nome_ong']."</h3>
            <p><strong>CNPJ:</strong> ".$row['cnpj']."</p>
            <p><strong>Área de atuação:</strong> ".$row['atuacao']."</p>
            <p><strong>Email:</strong> ".$row['email']."</p>
            <p><strong>Telefone:</strong> ".$row['telefone']."</p>
            <p><strong>Endereço:</strong> ".$row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']."</p>
        </div>";
} else {
    echo "<p>ONG não encontrada.</p>";
}

echo "<br>
      <a href='listar_ongs.php'><button>Voltar à lista</button></a>
      <a href='perfil_candidato.php'><button>Voltar ao Perfil</button></a>
</body>
</html>";

?>