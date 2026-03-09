<?php
session_start(); // Inicia a sessão para acessar dados do usuário logado
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Recupera o ID do candidato logado a partir da sessão
$id = $_SESSION['id']; //  Sugestão: padronizar para $_SESSION['candidato_id']

// Captura os dados enviados pelo formulário
$nome = $_POST['nome_candidato'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

// Atualiza o nome do candidato, se foi enviado
if (!empty($_POST['nome_candidato'])) {
    $nome = $_POST['nome_candidato'];
    mysqli_query($conn, "UPDATE logins SET nome_candidato='$nome' WHERE id=$id");
}

// Atualiza contato (telefone e/ou email), se foi enviado
if (!empty($_POST['telefone']) || !empty($_POST['email'])) {
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    mysqli_query($conn, "UPDATE contato_candidato SET telefone='$telefone', email='$email' WHERE candidato_id=$id");
}

// Atualiza endereço, se algum campo foi enviado
if (!empty($_POST['rua']) || !empty($_POST['numero']) || !empty($_POST['cidade']) || !empty($_POST['estado']) || !empty($_POST['cep'])) {
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    mysqli_query($conn, "UPDATE endereco_candidato 
        SET rua='$rua', numero='$numero', cidade='$cidade', estado='$estado', cep='$cep' 
        WHERE candidato_id=$id");
}

// Exibe mensagem de sucesso e redireciona para o perfil do candidato
echo "<script>
        alert('Dados atualizados com sucesso!'); 
        window.location.href='perfil_candidato.php';
      </script>";
?>