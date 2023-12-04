<?php
require('../modelo/clsUsuario.php');

$usuario = new clsUsuario();
$usuario->setNome($_POST['txtNome']);
$usuario->setLogin($_POST['txtLogin']);
$usuario->setSenha($_POST['txtSenha']);
$usuario->setPerfil($_POST['slcPerfil']);
$usuario->setFoto($_FILES['txtArquivo']);

if ($usuario->existeLogin() == false)
	if ($usuario->salvar() == true) {
		#header('location:lista_usuario.php');
		echo 'Salvo!';
	} else {
		echo 'Problema ao inserir o registro no banco de dados <br>';
	}
else {
	echo 'Esse usu&aacute;rio j&aacute; existe!';
}

echo '<a href="frmNovoUsuario.php"> VOLTAR </a>';
