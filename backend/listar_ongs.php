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

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>ONGs cadastradas</title>
    <link rel='stylesheet' href='/ajuda-aqui/frontend/css/arena.css'>
</head>
<body>
    <h2>ONGs cadastradas</h2>
    <div class='card-container'>";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>
                <h3>".$row['nome_ong']."</h3>
                <p><strong>CNPJ:</strong> ".$row['cnpj']."</p>
                <p><strong>Área de atuação:</strong> ".$row['atuacao']."</p>
                <p><strong>Email:</strong> ".$row['email']."</p>
                <p><strong>Telefone:</strong> ".$row['telefone']."</p>
                <p><strong>Endereço:</strong> ".$row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']."</p>
                <a href='detalhe_ong.php?id=".$row['id']."'>
                    <button>Ver detalhes</button>
                </a>
            </div>";
    }
} else {
        echo "<p>Nenhuma ONG cadastrada.</p>";
}
echo "</div>
    <br>
    <a href='perfil_candidato.php'>
        <button>Voltar ao Perfil</button>
    </a>
</body>
</html>";
?>