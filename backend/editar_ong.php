<?php
session_start(); // Inicia a sessão para acessar dados da ONG logada
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Recupera o ID da ONG logada a partir da sessão
$id = $_SESSION['id']; // Sugestão: padronizar para $_SESSION['ong_id']

// Atualiza nome, CNPJ e área de atuação, se algum desses campos foi enviado
if (!empty($_POST['nome_ong']) || !empty($_POST['cnpj']) || !empty($_POST['atuacao'])) {
    $nome = $_POST['nome_ong'];
    $cnpj = $_POST['cnpj'];
    $atuacao = $_POST['atuacao'];

    mysqli_query($conn, "UPDATE login_ong 
        SET nome_ong='$nome', cnpj='$cnpj', atuacao='$atuacao' 
        WHERE id=$id");
}

// Atualiza contato (telefone e/ou email), se foi enviado
if (!empty($_POST['telefone']) || !empty($_POST['email'])) {
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    mysqli_query($conn, "UPDATE contato 
        SET telefone='$telefone', email='$email' 
        WHERE ong_id=$id");
}

// Atualiza endereço, se algum campo foi enviado
if (!empty($_POST['rua']) || !empty($_POST['numero']) || !empty($_POST['cidade']) || !empty($_POST['estado']) || !empty($_POST['cep'])) {
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    mysqli_query($conn, "UPDATE endereco 
        SET rua='$rua', numero='$numero', cidade='$cidade', estado='$estado', cep='$cep' 
        WHERE ong_id=$id");
}

// Exibe mensagem de sucesso e redireciona para o painel da ONG
echo "<script>
        alert('Dados da ONG atualizados com sucesso!'); 
        window.location.href='/ajuda-aqui/backend/painel_ong.php';
      </script>";
?>