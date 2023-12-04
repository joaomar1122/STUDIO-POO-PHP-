<?php
class clsConexao
{
	# VARIÁVEIS PRIVADAS
	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $conexao;

	# PROPRIEDADES

	# servername
	public function setServername($valor)
	{
		$this->servername = $valor;
	}

	public function getServername()
	{
		return $this->servername;
	}

	# username
	public function setUsername($valor)
	{
		$this->username = $valor;
	}

	public function getUsername()
	{
		return $this->username;
	}

	# password
	public function setPassword($valor)
	{
		$this->password = $valor;
	}

	public function getPassword()
	{
		return $this->password;
	}

	# dbname
	public function setDbname($valor)
	{
		$this->dbname = $valor;
	}

	public function getDbname()
	{
		return $this->dbname;
	}

	# M

	public function __construct()
	{
		$this->conexao = new mysqli('localhost', 'root', '', 'bd_notas');
		if ($this->conexao->connect_error) {
			die('Erro na conexão: ' . $this->conexao->connect_error);
		}
	}

	public function getConexao()
	{
		return $this->conexao;
	}

	/* Método que executa uma string SQL no banco de dados */
	public function executaSQL($sql)
	{
		$resposta = mysqli_query($this->conexao, $sql) or die(mysqli_error($this->conexao));
		return $resposta;
	}
}
