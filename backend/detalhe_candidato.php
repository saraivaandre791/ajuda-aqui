<?php
session_start(); // Inicia a sessão para manter dados do usuário logado
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Pega o ID do candidato pela URL (ex.: detalhe_candidato.php?id=3)
// Usa intval() para garantir que seja um número inteiro e evitar SQL injection básico
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Monta a consulta SQL para buscar dados do candidato
// Junta informações de login, contato e endereço usando LEFT JOIN
$sql = "SELECT l.id, l.nome_candidato,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id
        WHERE l.id = $id";

$result = mysqli_query($conn, $sql); // Executa a consulta

// Estrutura básica da página HTML
echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Detalhes do Candidato</title>
    <link rel='stylesheet' href='/ajuda-aqui/frontend/css/arena.css'>
</head>
<body>
    <h2>Detalhes do Candidato</h2>";

// Se encontrou algum candidato com o ID informado
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Pega os dados do candidato

    // Exibe os dados formatados em um container
    echo "<div class='perfil-container'>
            <h3>".$row['nome_candidato']."</h3>
            <p><strong>Email:</strong> ".$row['email']."</p>
            <p><strong>Telefone:</strong> ".$row['telefone']."</p>
            <p><strong>Endereço:</strong> ".$row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']."</p>
        </div>";
} else {
    // Caso não exista candidato com o ID informado
    echo "<p>Candidato não encontrado.</p>";
}

// Botões de navegação para voltar à lista ou ao painel da ONG
echo "<br>
      <a href='listar_candidatos.php'><button>Voltar à lista</button></a>
      <a href='painel_ong.php'><button>Voltar ao Painel</button></a>
</body>
</html>";
?>