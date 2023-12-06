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
		$sql = "SELECT status_pagamento FROM tb_status_nota WHERE id_status = :id";
		$stmt = $mysqli->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$status = '';
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$status = $row['status_pagamento'];
		}
		$mysqli = null;

		return $status;
	}
}
