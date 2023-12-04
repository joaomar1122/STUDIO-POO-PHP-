<?php
require_once('../controle/clsConexao.php');
require_once('clsComum.php');

class clsStatus extends clsComum
{
	function __construct()
	{
	}

	public function pegaStatus()
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();
		$status = $mysqli->query('SELECT * from tb_status_nota;');
		return $status;
	}

	public function pegaStatusPorId($id)
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();
		$sql = "SELECT status_pagamento FROM tb_status_nota WHERE id_status=" . $id . ";";

		$tabela = $mysqli->query($sql);
		$status = '';

		while ($linha = mysqli_fetch_row($tabela)) {
			$status = $linha[0];
		}

		return $status;
	}
}
