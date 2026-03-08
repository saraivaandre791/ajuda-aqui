<?php
session_start();
include("conexao.php");

$login = $_POST['login'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM login_ong WHERE login='$login' AND senha='$senha'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $_SESSION['tipo'] = "ong";
    $_SESSION['login'] = $login;
    // Redireciona para o dashboard de ONG
    header("Location: dashboard_ong.php");
    exit;
}else {
    echo "Usuário ou senha invalidos";
}
?>