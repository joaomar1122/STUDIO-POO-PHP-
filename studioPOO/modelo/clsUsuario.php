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

	#PROPRIEDADES
	#Nome
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
		$mysqli = $conexao->getConexao();

		$stmt = $mysqli->prepare("INSERT INTO tb_cliente (nome_cliente) VALUES (?)");
		$stmt->bind_param("s", $this->nome);
		$stmt->execute();
		$id_cliente = $mysqli->insert_id;

		$stmt = $mysqli->prepare("INSERT INTO tb_servico (tipo_servico) VALUES (?)");
		$stmt->bind_param("s", $this->servico);
		$stmt->execute();
		$id_servico = $mysqli->insert_id;

		$stmt = $mysqli->prepare("INSERT INTO tb_notas (data_nota, preco_nota, id_pagamento, id_cliente, id_servico, id_status) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sdiidi", $this->data, $this->preco, $this->forma_pagamento, $id_cliente, $id_servico, $this->status_pagamento);
		$stmt->execute();
	}



	public function exclui()
	{
		$conexao = new clsConexao();
		$mysqli = $conexao->getConexao();

		if (isset($_GET['id'])) {
			$id_notas = $_GET['id'];

			$sql = "DELETE FROM tb_notas WHERE id_notas = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("i", $id_notas);
			if ($stmt->execute()) {
				header('Location: tabela.php');
				exit;
			} else {
				echo "Erro ao excluir o registro: " . $mysqli->error;
			}

			$stmt->close();
		}

		$mysqli->close();
	}
}
