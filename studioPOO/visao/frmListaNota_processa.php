<?php
require_once('../modelo/clsUsuario.php');
require_once('../controle/clsControlesHTML.php');

$idNota = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($idNota !== null) {
	$usuario = new clsUsuario();
	$usuario->setId($idNota);

	if ($action === 'excluir') {
		if ($usuario->exclui() == true) {
			header('location:frmListaNota.php');
			exit;
		} else {
			echo 'Problema ao apagar o registro no banco de dados. <br>
              <a href="frmListaNota.php"> VOLTAR </a>';
		}
	} elseif ($action === 'alterar') {
		if ($usuario->altera() == true) {
			header('location:frmListaNota.php');
			exit;
		} else {
			echo 'Problema ao atualizar o registro no banco de dados. <br>
              <a href="frmListaNota.php"> VOLTAR </a>';
		}
	} else {
		echo 'Ação inválida';
	}
} else {
	echo "ID DA NOTA NÃO FORNECIDO";
}
