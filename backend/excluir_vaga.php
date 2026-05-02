<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['ong_id'])) {
    header("Location: ../frontend/html/login_ong.html");
    exit;
}

$idOng = intval($_SESSION['ong_id']);
$idVaga = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($idVaga > 0) {
    // Exclui apenas se a vaga pertencer à ONG logada
    $sql = "DELETE FROM vaga WHERE id = $idVaga AND ong_id = $idOng";
    if (mysqli_query($conn, $sql)) {
        // Redireciona de volta ao painel
        header("Location: painel_ong.php");
        exit;
    } else {
        echo "Erro ao excluir vaga: " . mysqli_error($conn);
    }
} else {
    echo "Vaga inválida.";
}
?>
