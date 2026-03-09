<?php
session_start(); // Inicia a sessão para armazenar dados da ONG logada
include("conexao.php"); // Inclui o arquivo de conexão com o banco de dados

// Captura os dados enviados pelo formulário de login
// Se não houver valor, define como string vazia para evitar erros
$login = $_POST['login'] ?? '';
$senha = $_POST['senha'] ?? '';

// Consulta SQL para verificar se existe uma ONG com esse login e senha
$sql = "SELECT * FROM login_ong WHERE login='$login' AND senha='$senha'";
$result = mysqli_query($conn, $sql); // Executa a consulta

// Se encontrou algum registro válido
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result); // Pega os dados da ONG

    // Salva informações da ONG na sessão para identificar quem está logado
    $_SESSION['ong_id'] = $row['id']; // sugestão Padronizar para ong_id
    $_SESSION['tipo'] = "ong"; // Define o tipo de usuário como ONG
    $_SESSION['login'] = $row['login']; // Guarda o login usado

    // Redireciona para o painel da ONG
    header("Location: painel_ong.php");
    exit;
} else {
    // Caso não exista ONG com esse login/senha
    echo "Usuário ou senha inválidos";
}
?>