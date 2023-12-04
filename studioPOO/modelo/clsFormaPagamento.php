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

		$tabela = $mysqli->query($sql);
		$forma_pagamento = '';

		while ($linha = mysqli_fetch_row($tabela)) {
			$forma_pagamento = $linha[0];
		}

		return $forma_pagamento;
	}
}
