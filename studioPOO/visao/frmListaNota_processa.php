<?php
require_once('../modelo/clsUsuario.php');
require_once('../controle/clsConexao.php');

$usuario = new clsUsuario();


if (isset($_POST['btnExcluir'])) {
	if ($usuario->exclui() == true)
		header('location:frmListaNota.php');
	else {
		echo 'Problema ao apagar o registro no banco de dados. <br>
			<a href="frmListaNota.php"> VOLTAR </a>';
	}
} else #alterar
{

	if (isset($_GET['id'])) {
		$id = $_GET['id'];



		$conexao = new mysqli('localhost', 'root', '', 'bd_notas');

		if ($conexao->connect_error) {
			die('Erro na conexão: ' . $conexao->connect_error);
		}


		$sql = "UPDATE tb_notas SET id_status = 1 WHERE id_notas = ?";
		$stmt = $conexao->prepare($sql);
		$stmt->bind_param("i", $id); // 'i' indica um valor inteiro
		if ($stmt->execute()) {
			exit;
		} else {
			echo "Erro ao atualizar o status de pagamento: " . $conexao->error;
		}

		$stmt->close();
	} else {
		echo 'Problema ao apagar o registro no banco de dados. <br>
			<a href="frmListaNota.php"> VOLTAR </a>';
	}
}
