<?php
require_once('../modelo/clsFormaPagamento.php');
require_once('../modelo/clsStatus.php');
require_once('../modelo/clsUsuario.php');
class clsControlesHTML
{
	#construtor
	function __construct()
	{
	}

	public function geraSelect($nome, $dadosSelecionados, $codigoSelecionado = '')
	{
		$options = '<select name="' . $nome . '">';

		foreach ($dadosSelecionados as $linha) {
			if ($codigoSelecionado == $linha[0]) {
				$options .= '<option value="' . $linha[0] . '" selected="selected">' . $linha[1] . '</option>';
			} else {
				$options .= '<option value="' . $linha[0] . '">' . $linha[1] . '</option>';
			}
		}

		return $options . '</select>';
	}



	public function pegaUsuarios()
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();
		$sql = "SELECT n.id_notas, n.nome_cliente, n.data_nota, n.preco_nota, ss.status_pagamento, p.forma_pagamento, n.tipo_servico
				FROM  tb_notas as n, tb_pagamento as p,tb_status_nota as ss
				WHERE
				(p.id_pagamento = n.id_pagamento)
				AND (ss.id_status = n.id_status)
				ORDER BY n.id_notas;";
		return $mysqli->query($sql);
	}

	public function geraGrid($tabela)
	{
		$htmlTabela = '<table class="w3-table-all">
              <thead>
                     <tr class="w3-red">
                            <th>Nome</th>
                            <th>Servi&ccedil;os</th>
                            <th>Pre&ccedil;o</th>
                            <th>Data</th>
                            <th>Forma de Pagamento</th>
                            <th>Pago Ou N&atilde;o</th>
                            <th colspan="2">Ações</th>
                     </tr>
              </thead>
              <tbody>';

		$usuarios = $this->pegaUsuarios();

		while ($linha = $usuarios->fetch(PDO::FETCH_ASSOC)) {
			$htmlTabela .= '<tr>
				<td>' .  htmlentities($linha['nome_cliente']) . '</td>
				<td>' .  htmlentities($linha['tipo_servico']) . '</td>
				<td>R$' . htmlentities($linha['preco_nota']) . '</td>
				<td>' . htmlentities($linha['data_nota']) . '</td>
				<td>' . htmlentities($linha['forma_pagamento']) . '</td>
				<td>'   . htmlentities($linha['status_pagamento']) . '</td>';

			if ($linha['status_pagamento'] == "N&atilde;o Pago") {
				$htmlTabela .= '<td><center><a href="frmListaNota_processa.php?id=' . $linha['id_notas'] . '&action=alterar">Alterar</a></td>';
			} else {
				$htmlTabela .= '<td></td>';
			}

			$htmlTabela .= '<td><center><a href="frmListaNota_processa.php?id=' . $linha['id_notas'] . '&action=excluir">Excluir</a></td>

       	</tr>';
		}

		$htmlTabela .= '</tbody></table>';

		return $htmlTabela;
	}
}
