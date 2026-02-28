<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "formulario";

$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

if(!$conn){
    die("Falha na conexão: " . mysqli_connect_error());
}else { 
    echo "Conexão realizada com sucesso!"; 
}
?>