<?php
session_start();
include("conexao.php");

// Recupera o ID da ONG logada
$id = $_SESSION['ong_id']; // padronizado

// Atualiza nome, CNPJ e área de atuação dinamicamente
$updates = [];
if (!empty($_POST['nome_ong'])) {
    $updates[] = "nome_ong='" . $_POST['nome_ong'] . "'";
}
if (!empty($_POST['cnpj'])) {
    $updates[] = "cnpj='" . $_POST['cnpj'] . "'";
}
if (!empty($_POST['atuacao'])) {
    $updates[] = "atuacao='" . $_POST['atuacao'] . "'";
}

if (!empty($updates)) {
    $sql = "UPDATE login_ong SET " . implode(", ", $updates) . " WHERE id=$id";
    mysqli_query($conn, $sql);
}

// Atualiza contato dinamicamente
$updatesContato = [];
if (!empty($_POST['telefone'])) {
    $updatesContato[] = "telefone='" . $_POST['telefone'] . "'";
}
if (!empty($_POST['email'])) {
    $updatesContato[] = "email='" . $_POST['email'] . "'";
}

if (!empty($updatesContato)) {
    $sql = "UPDATE contato SET " . implode(", ", $updatesContato) . " WHERE ong_id=$id";
    mysqli_query($conn, $sql);
}

// Atualiza endereço dinamicamente
$updatesEndereco = [];
if (!empty($_POST['rua'])) {
    $updatesEndereco[] = "rua='" . $_POST['rua'] . "'";
}
if (!empty($_POST['numero'])) {
    $updatesEndereco[] = "numero='" . $_POST['numero'] . "'";
}
if (!empty($_POST['cidade'])) {
    $updatesEndereco[] = "cidade='" . $_POST['cidade'] . "'";
}
if (!empty($_POST['estado'])) {
    $updatesEndereco[] = "estado='" . $_POST['estado'] . "'";
}
if (!empty($_POST['cep'])) {
    $updatesEndereco[] = "cep='" . $_POST['cep'] . "'";
}

if (!empty($updatesEndereco)) {
    $sql = "UPDATE endereco SET " . implode(", ", $updatesEndereco) . " WHERE ong_id=$id";
    mysqli_query($conn, $sql);
}

// Mensagem de sucesso
echo "<script>
        alert('Dados da ONG atualizados com sucesso!');
        window.location.href='/ajuda-aqui/backend/painel_ong.php';
      </script>";
?>