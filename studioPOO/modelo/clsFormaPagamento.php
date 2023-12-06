<?php
require_once('../controle/clsConexao.php');
require_once('clsComum.php');

class clsFormaPagamento extends clsComum
{
	function __construct()
	{
	}

	public function pegaFormaPagamento()
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();
		$forma_pagamento = $mysqli->query('SELECT * from tb_pagamento;');
		return $forma_pagamento;
	}

	public function pegaFormaPagamentoPorId($id)
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();
		$sql = "SELECT forma_pagamento FROM tb_pagamento WHERE id_pagamento=" . $id . ";";
		$stmt = $mysqli->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		$forma_pagamento = '';
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$forma_pagamento = $row['forma_pagamento'];
		}
		$mysqli = null;

		return $forma_pagamento;
	}
}
