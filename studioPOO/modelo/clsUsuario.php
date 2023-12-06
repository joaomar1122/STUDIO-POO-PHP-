<?php
require_once('../controle/clsConexao.php');

class clsUsuario
{
	#VARIAVEIS PRIVADAS
	private $nome;
	private $servico;
	private $preco;
	private $data;

	private $forma_pagamento;
	private $status_pagamento;
	private $id_notas;

	#PROPRIEDADES
	public function setId($id)
	{
		$this->id_notas = $id;
	}
	public function setNome($valor)
	{
		$this->nome = $valor;
	}

	public function getNome()
	{
		return $this->nome;
	}


	public function getServico()
	{
		return $this->servico;
	}


	public function setServico($valor)
	{
		$this->servico = $valor;
	}


	public function getPreco()
	{
		return $this->preco;
	}


	public function setPreco($valor)
	{
		$preco_nota = str_replace(',', '.', $valor); // Usar $preco ao invés de $_POST['preco']
		if (!is_numeric($preco_nota)) {
			die("Erro: Preço inválido.");
		} else {
			$this->preco = $preco_nota; // Atribuir o preço corrigido à propriedade
		}
	}


	public function getData()
	{
		return $this->data;
	}

	public function setData($valor)
	{
		$this->data = $valor;
	}


	public function getForma_pagamento()
	{
		return $this->forma_pagamento;
	}


	public function setForma_pagamento($id_pagamento)
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();
		if (isset($_POST['slcFormaPagamento'])) {
			$forma_pagamento = $_POST['slcFormaPagamento'];
			$id_pagamento = $forma_pagamento;
		} else {
			die("Erro: Forma de pagamento inválida.");
		}
		$this->forma_pagamento = $id_pagamento;
	}

	public function getStatus_pagamento()
	{
		return $this->status_pagamento;
	}

	public function setStatus_pagamento($id_status)
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();
		if (isset($_POST['slcStatus'])) {
			$status = $_POST['slcStatus'];
			$id_status = $status;
		} else {
			die("Erro: Status de Pagamento Invalido.");
		}
		$this->status_pagamento = $id_status;
	}

	public function salvar()
	{
		$conexao = new clsConexao();
		$pdo = $conexao->getConexao();

		try {
			$sql = ("INSERT INTO tb_notas (data_nota, preco_nota, id_pagamento, nome_cliente, tipo_servico, id_status) VALUES (:data_nota,:preco,:forma_pagamento,:nome,:servico,:status_pagamento)");
			$prepare = $pdo->prepare($sql);
			$prepare->bindParam(":data_nota", $this->data, PDO::PARAM_STR);
			$prepare->bindParam(":preco", $this->preco, PDO::PARAM_STR);
			$prepare->bindParam(":forma_pagamento", $this->forma_pagamento, PDO::PARAM_INT);
			$prepare->bindParam(":nome", $this->nome, PDO::PARAM_STR);
			$prepare->bindParam(":servico", $this->servico, PDO::PARAM_STR);
			$prepare->bindParam(":status_pagamento", $this->status_pagamento, PDO::PARAM_INT);
			$count = $prepare->execute();

			echo "$count linhas afetadas.<br>";
			echo "Erro na execução com o banco de dados. Informe ao programador o seguinte erro: <br>";
			echo "Código: " . $prepare->errorInfo()[1] . "<br>";
			echo "Mensagem: " . $prepare->errorInfo()[2] . "<br>";
		} catch (PDOException $err) {

			echo $err->getMessage();
		}
	}

	public function exclui()
	{
		$conexao = new clsConexao();
		$pdo = $conexao->getConexao();

		if (isset($_GET['id'])) {
			try {
				$id_notas = $_GET['id'];

				$sql = "DELETE FROM tb_notas WHERE id_notas = ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_notas]);

				if ($stmt->rowCount() > 0) {
					return true;
				} else {
					echo "Nenhum registro foi excluído.";
					return false;
				}
			} catch (PDOException $e) {
				echo "Erro ao excluir o registro: " . $e->getMessage();
				return false;
			}
		} else {
			echo "ID de notas não definido.";
			return false;
		}
	}


	public function altera()
	{
		$conexao = new clsConexao();
		$pdo = $conexao->getConexao();

		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$sql = "UPDATE tb_notas SET id_status = 1 WHERE id_notas = ?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$id]);

			if ($stmt->rowCount() > 0) {
				return true;
			} else {
				echo "Erro ao atualizar o status de pagamento.";
				return false;
			}
		} else {
			echo "ID de notas não definido.";
			return false;
		}
	}
}
