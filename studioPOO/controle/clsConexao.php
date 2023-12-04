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

	# MÉTODOS

	# construtor
	public function __construct()
	{
		$this->servername = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->dbname = 'bd_notas';
		$this->conecta();
	}

	/* Método que usa as informações para criar um
    objeto de conexão ao banco */
	public function conecta()
	{
		$this->conexao = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
	}

	/* Método que executa uma string SQL no banco de dados */
	public function executaSQL($sql)
	{
		$resposta = mysqli_query($this->conexao, $sql) or die(mysqli_error($this->conexao));
		return $resposta;
	}
}
