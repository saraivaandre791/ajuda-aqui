<?php
include("conexao.php");

$nome = $_POST['nome_ong'];
$cnpj = $_POST['cnpj'];
$atuacao = $_POST['atuacao'];
$login = $_POST['login'];
$senha = $_POST['senha'];

$telefone = $_POST['telefone'];
$email = $_POST['email'];

$rua = $_POST['rua'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];

// 1. Inserir ONG na tabela login_ong
$sql_ong = "INSERT INTO login_ong (nome_ong, cnpj, atuacao, login, senha)
            VALUES ('$nome', '$cnpj', '$atuacao', '$login', '$senha')";
if(mysqli_query($conn, $sql_ong)){
    $ong_id = mysqli_insert_id($conn);

    // 2. Inserir contato
    $sql_contato = "INSERT INTO contato (telefone, email, ong_id)
                    VALUES ('$telefone', '$email', '$ong_id')";  
    mysqli_query($conn, $sql_contato);

    // 3. Inserir endereço
    $sql_endereco = "INSERT INTO endereco (rua, numero, cidade, estado, cep, ong_id)
                    VALUES ('$rua', '$numero', '$cidade', '$estado', '$cep', '$ong_id')";
    mysqli_query($conn, $sql_endereco);
    
    echo "Cadastro de ONG realizado com sucesso!";
    echo "<br><a href='../frontend/html/login_ong.html'><button>Ir para Login</button></a>";
}else{
    echo "Erro: " . mysqli_error($conn);
}

?>