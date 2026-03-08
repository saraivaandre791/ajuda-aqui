<?php
session_start();
include("conexao.php");

$id = $_SESSION['id']; // id do candidato logado

$nome = $_POST['nome_candidato'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

// Atualizar nome
if (!empty($_POST['nome_candidato'])) {
    $nome = $_POST['nome_candidato'];
mysqli_query($conn, "UPDATE logins SET nome_candidato='$nome' WHERE id=$id");
}

// Atualiza contato
if (!empty($_POST['telefone']) || !empty($_POST['email'])) {
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
mysqli_query($conn, "UPDATE contato_candidato SET telefone='$telefone', email='$email' WHERE candidato_id=$id");
}

// Atualiza endereço
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
    echo "<script>
            alert('Dados atualizados com sucesso!'); 
            window.location.href='perfil_candidato.php';
        </script>";
?>