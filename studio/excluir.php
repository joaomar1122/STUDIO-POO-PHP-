<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'bd_notas';
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_notas = $_GET['id'];

    $sql = "DELETE FROM tb_notas WHERE id_notas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_notas);
    if ($stmt->execute()) {
        header('Location: tabela.php');
        exit;
    } else {
        echo "Erro ao excluir o registro: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
