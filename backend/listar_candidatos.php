<?php
session_start(); // Inicia a sessão para manter dados do usuário logado
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Consulta SQL para buscar todos os candidatos cadastrados
// Junta informações de login, contato e endereço usando LEFT JOIN
$sql = "SELECT l.id, l.nome_candidato,
               c.telefone, c.email,
               e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM logins l
        LEFT JOIN contato_candidato c ON l.id = c.candidato_id
        LEFT JOIN endereco_candidato e ON l.id = e.candidato_id";

$result = mysqli_query($conn, $sql); // Executa a consulta

// Estrutura básica da página HTML
echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>Candidatos Registrados</title>
    <link rel='stylesheet' href='/ajuda-aqui/frontend/css/arena.css'>
</head>
<body>
    <h2>Candidatos Registrados</h2>
    <div class='card-container'>";

// Se encontrou candidatos cadastrados
if (mysqli_num_rows($result) > 0) {
    // Loop para exibir cada candidato em um card
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>
                <h3>".$row['nome_candidato']."</h3>
                <p><strong>Email:</strong> ".$row['email']."</p>
                <p><strong>Telefone:</strong> ".$row['telefone']."</p>
                <p><strong>Endereço:</strong> ".$row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']."</p>
                <!-- Botão que leva para a página de detalhes do candidato -->
                <a href='detalhe_candidato.php?id=".$row['id']."'>
                    <button>Ver detalhes</button>
                </a>
            </div>";
    }
} else {
    // Caso não exista nenhum candidato cadastrado
    echo "<p>Nenhum candidato cadastrado.</p>";
}

// Fecha o container e adiciona botão para voltar ao painel da ONG
echo "</div>
    <br>
    <a href='painel_ong.php'>
        <button>Voltar ao Painel</button>
    </a>
</body>
</html>";
?>