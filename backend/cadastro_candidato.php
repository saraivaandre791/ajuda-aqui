<?php
// Inclui o arquivo de conexão com o banco de dados
include("conexao.php");

// Recebe os dados enviados pelo formulário de cadastro de candidato
$nome = $_POST['nome_candidato'];
$login = $_POST['login'];
$senha = $_POST['senha'];

$telefone = $_POST['telefone'];
$email = $_POST['email'];

$rua = $_POST['rua'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

// 1. Inserir candidato na tabela logins
$sql_candidato = "INSERT INTO logins (nome_candidato, login, senha) 
                VALUES ('$nome', '$login', '$senha')";
if(mysqli_query($conn, $sql_candidato)){
    $candidato_id = mysqli_insert_id($conn); // pega o ID gerado

    // 2. Inserir contato do candidato, usando o ID como chave estrangeira
    $sql_contato = "INSERT INTO contato_candidato (telefone, email, candidato_id)
                    VALUES ('$telefone', '$email', '$candidato_id')";
    mysqli_query($conn, $sql_contato);

    // Se houve erro no contato, mostra mensagem
    if(!mysqli_query($conn, $sql_contato)){ 
        echo "Erro contato: " . mysqli_error($conn); 
    }

    // 3. Inserir endereço do candidato, também ligado ao ID
    $sql_endereco = "INSERT INTO endereco_candidato (rua, numero, cidade, estado, cep, candidato_id)
                    VALUES ('$rua', '$numero', '$cidade', '$estado', '$cep', '$candidato_id')";
    mysqli_query($conn, $sql_endereco);

    // Se houve erro no endereço, mostra mensagem
    if(!mysqli_query($conn, $sql_endereco)){ 
        echo "Erro endereço: " . mysqli_error($conn); 
    }

    // Mensagem final de sucesso + redirecionamento para peerfil
    header("Location: perfil_candidato.php?id=$candidato_id");
    exit;
    
}
?>