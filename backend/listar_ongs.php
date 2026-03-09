<?php
session_start(); // Inicia a sessão para manter dados do usuário logado
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Consulta SQL para buscar todas as ONGs cadastradas
// Junta informações de login, contato e endereço usando LEFT JOIN
$sql = "SELECT l.id, l.nome_ong, l.cnpj, l.atuacao,
                c.telefone, c.email,
                e.rua, e.numero, e.cidade, e.estado, e.cep
        FROM login_ong l
        LEFT JOIN contato c ON l.id = c.ong_id
        LEFT JOIN endereco e ON l.id = e.ong_id";

$result = mysqli_query($conn, $sql); // Executa a consulta

// Estrutura básica da página HTML
echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <title>ONGs Registradas</title>
    <link rel='stylesheet' href='/ajuda-aqui/frontend/css/arena.css'>
</head>
<body>
    <h2>ONGs Registradas</h2>
    <div class='card-container'>";

// Se encontrou ONGs cadastradas
if (mysqli_num_rows($result) > 0) {
    // Loop para exibir cada ONG em um card
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>
                <h3>".$row['nome_ong']."</h3>
                <p><strong>CNPJ:</strong> ".$row['cnpj']."</p>
                <p><strong>Email:</strong> ".$row['email']."</p>
                <p><strong>Telefone:</strong> ".$row['telefone']."</p>
                <p><strong>Endereço:</strong> ".$row['rua'].", ".$row['numero']." - ".$row['cidade']."/".$row['estado']." - CEP ".$row['cep']."</p>
                <!-- Botão que leva para a página de detalhes da ONG -->
                <a href='detalhe_ong.php?id=".$row['id']."'>
                    <button>Ver detalhes</button>
                </a>
            </div>";
    }
} else {
    // Caso não exista nenhuma ONG cadastrada
    echo "<p>Nenhuma ONG cadastrada.</p>";
}

// Fecha o container e adiciona botão para voltar ao perfil do candidato
echo "</div>
    <br>
    <a href='perfil_candidato.php'>
        <button>Voltar ao Perfil</button>
    </a>
</body>
</html>";
?>