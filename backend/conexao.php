<?php
// Define credenciais de conexão com o banco de dados
$servidor = "localhost"; // Endereço do servidor MySQL (localhost = maquina local)
$usuario = "root"; // Usuário padrão do MySQL
$senha = ""; // Senha do usuário (em branco no XAMPP por padrão)
$banco = "formulario"; // Nome do banco de dados que será utilizado

// Cria a conexão com o banco usando mysqli
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica se a conexão foi bem-sucedida
if(!$conn){
    // Se não conectar, encerra o script e mostra o erro
    die("Falha na conexão: " . mysqli_connect_error());
}else { 
    // Se conectar, exibe mensagem de sucesso
    echo "Conexão realizada com sucesso!"; 
}
?>