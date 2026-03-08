<?php
// Inicia a sessão para poder armazenar dados do usuário enquanto ele navega
session_start();



// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

// Recebe os dados enviados pelo formulário de login
$login = $_POST['login'];
$senha = $_POST['senha'];

// Monta a consulta SQL para verificar se existe um candidato com esse login e senha
$sql = "SELECT * FROM logins WHERE login='$login' AND senha='$senha'";

// Executa a consulta no banco
$result = mysqli_query($conn, $sql);

// Verifica se encontrou algum registro
if(mysqli_num_rows($result) > 0){
    // Pega os dados do candidato
    $row = mysqli_fetch_assoc($result);

    // Se encontrou, define variáveis de sessão para identificar o usuário
    $_SESSION['id'] = $row['id'];          // ID do candidato
    $_SESSION['tipo'] = "candidato";// Tipo de usuário (candidato)
    $_SESSION['login'] = $row['login'];    // Login do usuário

    // Redireciona para o dashboard do candidato
    header("Location: perfil_candidato.php");
    exit;
}else {
    // Se não encontrou, mostra mensagem de erro
    echo "Usuario ou senha invalidos!";
}
?>