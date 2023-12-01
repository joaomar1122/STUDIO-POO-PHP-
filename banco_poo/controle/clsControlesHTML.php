<?php
require_once('../modelo/clsPerfil.php');

class clsControlesHTML
{
	#construtor
	function __construct()
	{
	}
	
	public function geraSelect($nome, $tabela, $codigoSelecionado = '')
	{
		$options = '<select name="'. $nome .'">';
		while ($linha = mysqli_fetch_row($tabela))
		{
			if ($codigoSelecionado == $linha[0])
			{
				$options .= '<option value="'.$linha[0].'" selected="selected">'.$linha[1].'</option>';
			}
			else
			{
				$options .= '<option value="'.$linha[0].'">'.$linha[1].'</option>';
			}
		}
		
		return $options . '</select>';
	}
	
	public function geraGrid($tabela)
	{
		$htmlTabela = '<table class="w3-table-all">
						<thead>
							<tr class="w3-red">
								<th>FOTO</th>
								<th>NOME</th>
								<th>LOGIN</th>
								<th>SENHA</th>
								<th>PERFIL</th>
								<th><center>ALTERAR</center></th>
								<th><center>EXCLUIR</center></th>														
							</tr>
						</thead>';
		
		$perfil = new clsPerfil();
		
		while ($linha = mysqli_fetch_row($tabela))
		{
			
			$select =$this->geraSelect('slcPerfil_'.$linha[0], $perfil->pegaPerfis(), $linha[4]);
			
			$htmlTabela .= '<tr>
								<td><img style="height:150px" src="imagens/'.$linha[2].'.jpg"></img><br><input type="file" size="30" name="txtArquivo_'.$linha[0].'"/></td>
								<td><input type="text" size="20" name="txtNome_'.$linha[0].'" value="'.$linha[1].'"/></td>
								<td><input type="text" size="10" readonly="true" class="login" name="txtLogin_'.$linha[0].'" value="'.$linha[2].'"/></td>
								<td><input type="text" size="10" name="txtSenha_'.$linha[0].'" value="'.$linha[3].'"/></td>
								<td>' . $select . '</td>												
								<td><center><button type="submit" name="btnAlterar" value="'.$linha[0].'">Alterar</button>
								<td><center><button type="submit" name="btnExcluir" value="'.$linha[0].'">Excluir</button>
							 </tr>';
		}

		$htmlTabela .= '</table>';
		
		return $htmlTabela;
	}
}
?>