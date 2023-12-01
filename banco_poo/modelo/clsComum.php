<?php
abstract class clsComum
{
	#VARIAVEIS PRIVADAS
	protected $id;
	protected $nome;
	
	#PROPRIEDADES
	#id
	public function setId($valor)
	{
		$this->id = $valor;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	#nome
	public function setNome($valor)
	{
		$this->nome = $valor;
	}
	
	public function getNome()
	{
		return $this->nome;
	}
}
?>