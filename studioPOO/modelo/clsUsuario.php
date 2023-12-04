clsUsuario:
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
		$conexao = new mysqli('localhost', 'root', '', 'bd_notas');
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
		$conexao = new mysqli('localhost', 'root', '', 'bd_notas');
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
		$conexao = new mysqli('localhost', 'root', '', 'bd_notas');

		if ($conexao->connect_error) {
			die('Erro na conexão: ' . $conexao->connect_error);
		}

		$sql = "INSERT INTO tb_cliente (nome_cliente) VALUES ('$this->nome')";
		$conexao->query($sql);


		$id_cliente = $conexao->insert_id;


		$sql = "INSERT INTO tb_servico (tipo_servico) VALUES ('$this->servico')";
		$conexao->query($sql);


		$id_servico = $conexao->insert_id;

		// if (isset($_POST['slcFormaPagamento'])) {
		// 	$forma_pagamento = $_POST['slcFormaPagamento'];
		// 	$id_pagamento = $forma_pagamento;
		// } else {
		// 	die("Erro: Forma de pagamento inválida.");
		// }
		// if (isset($_POST['slcStatus'])) {
		// 	$status = $_POST['slcStatus'];
		// 	$id_status = $status;
		// } else {
		// 	die("Erro: Status de Pagamento Invalido.");
		// }

		$stmt = $conexao->prepare("INSERT INTO tb_notas (data_nota, preco_nota, id_pagamento, id_cliente, id_servico, id_status) VALUES ('$this->data', '$this->preco', '$this->forma_pagamento', '$id_cliente', '$id_servico',$this->status_pagamento)");
		if (!$stmt) {
			die("Erro na preparação da consulta final: " . $conexao->error);
		}

		if (!$stmt->execute()) {
			die("Erro ao executar a consulta final: " . $stmt->error);
		}
	}


	public function exclui()
	{
		$conexao = new mysqli('localhost', 'root', '', 'bd_notas');
		if ($conexao->connect_error) {
			die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
		}

		if (isset($_GET['id'])) {
			$id_notas = $_GET['id'];

			$sql = "DELETE FROM tb_notas WHERE id_notas = ?";
			$stmt = $conexao->prepare($sql);
			$stmt->bind_param("i", $id_notas);
			if ($stmt->execute()) {
				header('Location: tabela.php');
				exit;
			} else {
				echo "Erro ao excluir o registro: " . $conexao->error;
			}

			$stmt->close();
		}

		$conexao->close();
	}
}
