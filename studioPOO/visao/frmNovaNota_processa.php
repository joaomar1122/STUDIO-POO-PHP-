<?php
require('../modelo/clsUsuario.php');

$usuario = new clsUsuario();

$usuario->setNome($_POST['nome_cliente']);
$usuario->setServico($_POST['tipo_servico']);
$usuario->setPreco($_POST['preco']);
$usuario->setData($_POST['data']);
$usuario->setForma_pagamento($_POST['slcFormaPagamento']);
$usuario->setStatus_pagamento($_POST['slcStatus']);


if ($usuario->salvar() == true) {
	#header('location:lista_usuario.php');
	echo 'Salvo!';
} else {
	echo 'Salvo!!';
}

echo '<a href="frmNovaNota.php"> VOLTAR </a>';