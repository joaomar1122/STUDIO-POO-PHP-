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

	public function geraSelect($nome, $tabela, $codigoSelecionado = '')
	{
		$options = '<select name="' . $nome . '">';
		while ($linha = mysqli_fetch_row($tabela)) {
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
		$sql = "SELECT n.id_notas, c.nome_cliente, n.data_nota, n.preco_nota, ss.status_pagamento, p.forma_pagamento, s.tipo_servico
				FROM tb_cliente as c, tb_notas as n, tb_pagamento as p, tb_servico as s,tb_status_nota as ss
				WHERE (c.id_cliente = n.id_cliente)
				AND (p.id_pagamento = n.id_pagamento)
				AND (s.id_servico = n.id_servico)
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

		while ($linha = $usuarios->fetch_assoc()) {
			$htmlTabela .= '<tr>
                            <td>' . $linha['nome_cliente'] . '</td>
                            <td>' . $linha['tipo_servico'] . '</td>
                            <td>R$' . $linha['preco_nota'] . '</td>
                            <td>' . $linha['data_nota'] . '</td>
                            <td>' . $linha['forma_pagamento'] . '</td>
                            <td>'  . $linha['status_pagamento'] . '</td>
				<td><center><button type="submit" name="btnAlterar" value="' . $linha['id_notas'] . '">Alterar</button>
				<td><center><button type="submit" name="btnExcluir" value="' . $linha['id_notas'] . '">Excluir</button>
                     </tr>';
		}

		$htmlTabela .= '</tbody></table>';

		return $htmlTabela;
	}
}
