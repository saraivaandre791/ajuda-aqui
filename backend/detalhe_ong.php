<?php
session_start(); // Inicia a sessão para manter dados do usuário logado
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Pega o ID da ONG pela URL (ex.: detalhe_ong.php?id=5)
// Usa intval() para garantir que seja um número inteiro e evitar SQL injection básico
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Monta a consulta SQL para buscar dados da ONG
// Junta informações de login, contato e endereço usando LEFT JOIN
$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql); // Executa a consulta

// Estrutura básica da página HTML
echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Detalhes da ONG</title>
    <link rel='stylesheet' href='/ajuda-aqui/frontend/css/arena.css'>
</head>
<body>
    <h2>Detalhes da ONG</h2>";

// Se encontrou alguma ONG com o ID informado
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Pega os dados da ONG

    // Exibe os dados formatados em um container
    echo "<div class='perfil-container'>
            <h3>".$row['nome_ong']."</h3>
            <p><strong>CNPJ:</strong> ".$row['cnpj']."</p>
            <p><strong>Área de atuação:</strong> ".$row['atuacao']."</p>
            <p><strong>Email:</strong> ".$row['email']."</p>
            <p><strong>Telefone:</strong> ".$row['telefone']."</p>
            <p><strong>Endereço:</strong> ".$row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']."</p>
        </div>";
} else {
    // Caso não exista ONG com o ID informado
    echo "<p>ONG não encontrada.</p>";
}

// Botões de navegação para voltar à lista de ONGs ou ao perfil do candidato
echo "<br>
      <a href='listar_ongs.php'><button>Voltar à lista</button></a>
      <a href='perfil_candidato.php'><button>Voltar ao Perfil</button></a>
</body>
</html>";

?>