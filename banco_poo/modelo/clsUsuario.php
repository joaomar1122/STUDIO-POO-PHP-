<?php
require_once('../controle/clsConexao.php');
require_once('../controle/clsArquivo.php');
require_once('clsComum.php');

class clsUsuario extends clsComum
{
	#VARIAVEIS PRIVADAS
	private $login;
	private $senha;
	private $perfil;
	private $foto;
	
	#PROPRIEDADES
	#login
	public function setLogin($valor)
	{
		$this->login = $valor;
	}
	
	public function getLogin()
	{
		return $this->login;
	}
	
	#senha
	public function setSenha($valor)
	{
		$this->senha = $valor;
	}
	
	public function getSenha()
	{
		return $this->senha;
	}
	
	#perfil
	public function setPerfil($valor)
	{
		$this->perfil = $valor;
	}
	
	public function getPerfil()
	{
		return $this->perfil;
	}
	
	#foto
	public function setFoto($valor)
	{
		$this->foto = $valor;
	}
	
	public function getFoto()
	{
		return $this->foto;
	}
	
	#METODOS
	public function existeLogin()
	{
		$conexao = new clsConexao();
		$sql = "SELECT * FROM tb_usuario WHERE login_usuario='" . $this->login . "';";
		
		$resultado = false;
		if (mysqli_num_rows($conexao->executaSQL($sql)) >= 1)
			$resultado = true;
		
		return $resultado;
	}
	
	public function salvar($novoUsuario = true)
	{
		#salva a foto
		$gravadorDeFoto = new clsArquivo();		
		$gravadorDeFoto->setNomeArquivo($this->login . '.jpg');
		$gravadorDeFoto->setDiretorio('../visao/imagens');
		$gravadorDeFoto->setArquivo($this->foto);
		$gravadorDeFoto->upload();
		
		if ($novoUsuario == true)#salva
		{
			$sql = "INSERT INTO tb_usuario(nome_usuario, login_usuario, senha_usuario, id_perfil) 
				    VALUES ('".$this->nome."','".$this->login."',
					'".$this->senha."',".$this->perfil.");";
		}
		else #alterar
		{
			$sql = "UPDATE tb_usuario SET 
			        nome_usuario='".$this->nome."', 
					senha_usuario='".$this->senha."', 
					id_perfil=".$this->perfil." 
					WHERE id_usuario=".$this->id.";"; 
		}
		
		$conexao = new clsConexao();	
		return $conexao->executaSQL($sql);
	}
	
	public function pegaUsuarios()
	{
		$conexao = new clsConexao();
		$sql = "SELECT * FROM tb_usuario;";
		return $conexao->executaSQL($sql);
	}
	
	public function exclui()
	{
		#exclui foto
		$gravadorDeFoto = new clsArquivo();		
		$gravadorDeFoto->setNomeArquivo($this->login . '.jpg');
		$gravadorDeFoto->setDiretorio('imagens');
		$gravadorDeFoto->excluiArquivo();
		
		#exclui dados
		$conexao = new clsConexao();
		$sql = "DELETE FROM tb_usuario WHERE login_usuario='" . $this->login . "';";
		return $conexao->executaSQL($sql);
	}
}

?>