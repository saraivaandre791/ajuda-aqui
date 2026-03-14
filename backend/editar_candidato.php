<?php
session_start();
include("conexao.php");

$id = $_SESSION['id']; // ID do candidato logado

// Captura os dados enviados pelo formulário
$nome    = $_POST['nome_candidato'];
$telefone= $_POST['telefone'];
$email   = $_POST['email'];
$rua     = $_POST['rua'];
$numero  = $_POST['numero'];
$cidade  = $_POST['cidade'];
$estado  = $_POST['estado'];
$cep     = $_POST['cep'];

// Atualiza nome
if (!empty($nome)) {
    mysqli_query($conn, "UPDATE logins SET nome_candidato='$nome' WHERE id=$id");
}

// Atualiza ou insere contato
if (!empty($telefone) || !empty($email)) {
    $sql_contato = "INSERT INTO contato_candidato (candidato_id, telefone, email)
                    VALUES ($id, '$telefone', '$email')
                    ON DUPLICATE KEY UPDATE telefone='$telefone', email='$email'";
    mysqli_query($conn, $sql_contato);
}

// Atualiza ou insere endereço
if (!empty($rua) || !empty($numero) || !empty($cidade) || !empty($estado) || !empty($cep)) {
    $sql_endereco = "INSERT INTO endereco_candidato (candidato_id, rua, numero, cidade, estado, cep)
                     VALUES ($id, '$rua', '$numero', '$cidade', '$estado', '$cep')
                     ON DUPLICATE KEY UPDATE 
                         rua='$rua', numero='$numero', cidade='$cidade', estado='$estado', cep='$cep'";
    mysqli_query($conn, $sql_endereco);
}

// Mensagem de sucesso e redirecionamento
echo "<script>
        alert('Dados atualizados com sucesso!');
        window.location.href='perfil_candidato.php';
      </script>";
?>