<?php
session_start();
include("conexao.php");

$login = $_POST['login'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM logins WHERE login='$login' AND senha='$senha'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $_SESSION['tipo'] = "candidato";
    $_SESSION['login'] = $login;
    header("Location: dashboard_candidato.php");
}else {
    echo "Usuario ou senha invalidos!";
}
?>