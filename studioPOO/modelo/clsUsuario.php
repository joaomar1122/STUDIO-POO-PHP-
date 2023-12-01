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
		public function setNome($nome)
		{
			$this->nome = $nome;
		}

		public function getNome()
		{
			return $this->nome;
		}


		public function getServico()
		{
			return $this->servico;
		}


		public function setServico($servico)
		{
			$this->servico = $servico;
		}


		public function getPreco()
		{
			return $this->preco;
		}


		public function setPreco($preco)
		{
			$preco_nota = str_replace(',', '.', $preco); // Usar $preco ao invés de $_POST['preco']
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

		public function setData($data)
		{
			$this->data = $data;
		}


		public function getForma_pagamento()
		{
			return $this->forma_pagamento;
		}


		public function setForma_pagamento($valor)
		{
			$this->forma_pagamento = $valor;
		}

		public function getStatus_pagamento()
		{
			return $this->status_pagamento;
		}

		/**
		 * @param mixed $status_pagamento
		 * @return self
		 */
		public function setStatus_pagamento($status_pagamento): self
		{
			$this->status_pagamento = $status_pagamento;
			return $this;
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

			if (isset($_POST['slcFormaPagamento'])) {
				$forma_pagamento = $_POST['slcFormaPagamento'];
				$id_pagamento = $forma_pagamento;
			} else {
				die("Erro: Forma de pagamento inválida.");
			}
			if (isset($_POST['slcStatus'])) {
				$status = $_POST['slcStatus'];
				$id_status = $status;
			} else {
				die("Erro: Status de Pagamento Invalido.");
			}

			$stmt = $conexao->prepare("INSERT INTO tb_notas (data_nota, preco_nota, id_pagamento, id_cliente, id_servico, id_status) VALUES ('$this->data', '$this->preco', '$id_pagamento', '$id_cliente', '$id_servico',$id_status)");
			if (!$stmt) {
				die("Erro na preparação da consulta final: " . $conexao->error);
			}

			if (!$stmt->execute()) {
				die("Erro ao executar a consulta final: " . $stmt->error);
			}
		}





		public function alteraStatus()
		{
			if (isset($_GET['id'])) {
				$id = $_GET['id'];



				$conexao = new mysqli('localhost', 'root', '', 'bd_notas');

				if ($conexao->connect_error) {
					die('Erro na conexão: ' . $conexao->connect_error);
				}


				$sql = "UPDATE tb_notas SET id_status = 1 WHERE id_notas = ?";
				$stmt = $conexao->prepare($sql);
				$stmt->bind_param("i", $id); // 'i' indica um valor inteiro
				if ($stmt->execute()) {
					header('Location: tabela.php');
					exit;
				} else {
					echo "Erro ao atualizar o status de pagamento: " . $conexao->error;
				}

				$stmt->close();
			} else {
				echo "ID da nota não fornecido.";
			}
		}

		// public function pegaUsuarios()
		// {
		// 	$conexao = new clsConexao();
		// 	$sql = "SELECT * FROM tb_usuario;";
		// 	return $conexao->executaSQL($sql);
		// }


		public function exclui()
		{
			#exclui dados

			$conexao = new mysqli('localhost', 'root', '', 'bd_notas');


			if ($conexao->connect_error) {
				die('Erro na conexão: ' . $conexao->connect_error);
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
			$conexao = new clsConexao();
			return $conexao->executaSQL($sql);
		}
	}
