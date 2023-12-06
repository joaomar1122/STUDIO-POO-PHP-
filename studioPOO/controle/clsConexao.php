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
		$this->servername = 'localhost';
		$this->username = 'root';
		$this->password = '';
		$this->dbname = 'bd_notas';

		$this->conexao =
			new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

		$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function getConexao()
	{
		return $this->conexao;
	}

	/* Método que executa uma string SQL no banco de dados */
	public function executaSQL($sql)
	{
		try {
			$resposta = $this->conexao->query($sql);
			return $resposta;
		} catch (PDOException $e) {
			echo "Erro ao executar a consulta: " . $e->getMessage();
			return false;
		}
	}
}
