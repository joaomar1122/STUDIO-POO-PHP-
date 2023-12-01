<?php
require_once('../controle/clsConexao.php');
require_once('clsComum.php');

class clsPerfil extends clsComum
{
	function __construct()
	{
	}

	public function pegaPerfis()
	{
		$conexao = new clsConexao();
		$perfis = $conexao->executaSQL('SELECT * from tb_perfil;');
		return $perfis;
	}

	public function pegaPerfilPorId($id)
	{
		$conexao = new clsConexao();
		$sql = "SELECT nome_perfil FROM tb_perfil WHERE id_perfil=" . $id . ";";

		$tabela = $conexao->executaSQL($sql);
		$nome_perfil = '';

		while ($linha = mysqli_fetch_row($tabela)) {
			$nome_perfil = $linha[0];
		}

		return $nome_perfil;
	}
}
