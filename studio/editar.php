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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    $sql = "UPDATE tb_notas SET pago_nota = 1 WHERE id_notas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // o I presente aqui significa um valor inteiro
    if ($stmt->execute()) {
        header('Location: tabela.php');
        exit;
    } else {
        echo "Erro ao atualizar o status de pagamento: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID da nota não fornecido.";
}
