<?php
require_once('../modelo/clsUsuario.php');

$usuario = new clsUsuario();

if (isset($_POST['btnExcluir'])) {
	$usuario->setNome($_POST['nome_cliente'] . $_POST['btnExcluir']);
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



		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();


		$sql = "UPDATE tb_notas SET id_status = 1 WHERE id_notas = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $id); // 'i' indica um valor inteiro
		if ($stmt->execute()) {
			exit;
		} else {
			echo "Erro ao atualizar o status de pagamento: " . $mysqli->error;
		}

		$stmt->close();
	} else {
		echo 'Problema ao apagar o registro no banco de dados. <br>
			<a href="frmListaNota.php"> VOLTAR </a>';
	}
}
