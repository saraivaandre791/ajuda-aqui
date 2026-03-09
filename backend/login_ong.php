<?php
session_start();
include("conexao.php");

$login = $_POST['login'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "SELECT * FROM login_ong WHERE login='$login' AND senha='$senha'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $_SESSION['ong_id'] = $row['id']; // padroniza
    $_SESSION['tipo'] = "ong";
    $_SESSION['login'] = $row['login'];

    header("Location: painel_ong.php");
    exit;
} else {
    echo "Usuário ou senha inválidos";
}
?>