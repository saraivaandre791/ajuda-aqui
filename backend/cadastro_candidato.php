<?php
include("conexao.php");

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

    // 2. Inserir contato
    $sql_contato = "INSERT INTO contato_candidato (telefone, email, candidato_id)
                    VALUES ('$telefone', '$email', '$candidato_id')";
    mysqli_query($conn, $sql_contato);

    if(!mysqli_query($conn, $sql_contato)){ 
        echo "Erro contato: " . mysqli_error($conn); 
    }

    // 3. INserir endereço
    $sql_endereco = "INSERT INTO endereco_candidato (rua, numero, cidade, estado, cep, candidato_id)
                    VALUES ('$rua', '$numero', '$cidade', '$estado', '$cep', '$candidato_id')";
    mysqli_query($conn, $sql_endereco);

    if(!mysqli_query($conn, $sql_endereco)){ 
        echo "Erro endereço: " . mysqli_error($conn); 
    }

    echo "Cadastro de candidato realizado com sucesso!";
    echo "<br><a href='../frontend/html/login_candidato.html'><button>Ir para Login</button></a>";
}else{
    echo "Erro: " . mysqli_error($conn);
}    
?>