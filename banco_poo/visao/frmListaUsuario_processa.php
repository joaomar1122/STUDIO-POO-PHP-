<?php
require_once('../modelo/clsUsuario.php');

$usuario = new clsUsuario();

if (isset($_POST['btnExcluir']))
{
	$usuario->setLogin($_POST['txtLogin_' . $_POST['btnExcluir']]);
	if ($usuario->exclui() == true)
		header('location:frmListaUsuario.php');
	else
	{
		echo 'Problema ao apagar o registro no banco de dados. <br>
			 <a href="frmListaUsuario.php"> VOLTAR </a>';
	}
}
else #alterar
{
	$usuario->setId($_POST['btnAlterar']);
	$usuario->setNome($_POST['txtNome_' . $_POST['btnAlterar']]);
	$usuario->setLogin($_POST['txtLogin_' . $_POST['btnAlterar']]);
	$usuario->setSenha($_POST['txtSenha_' . $_POST['btnAlterar']]);
	$usuario->setFoto($_FILES['txtArquivo_' . $_POST['btnAlterar']]);
	$usuario->setPerfil($_POST['slcPerfil_' . $_POST['btnAlterar']]);
	
	if ($usuario->salvar(false) == true)
		header('location:frmListaUsuario.php');
	else
	{
		echo 'Problema ao apagar o registro no banco de dados. <br>
			 <a href="frmListaUsuario.php"> VOLTAR </a>';
	}
}


?>