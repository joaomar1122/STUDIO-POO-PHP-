	<?php
	require_once('../modelo/clsFormaPagamento.php');
	require_once('../modelo/clsStatus.php');
	require_once('../controle/clsControlesHTML.php');
	?>

	<html>

	<head>
		<title>SISTEMA POO</title>
		<style>
			table {
				width: 100%;
			}

			table,
			th,
			td {
				border: 1px solid black;
				border-collapse: collapse;
			}

			th,
			td {
				padding: 5px;
				text-align: left;
			}

			table#t01 tr:nth-child(even) {
				background-color: #eee;
			}

			table#t01 tr:nth-child(odd) {
				background-color: #fff;
			}

			table#t01 th {
				background-color: black;
				color: white;
			}
		</style>
	</head>

	<body>
		<table>
			<tr style="height:50px">
				<td colspan="2">
					<h1>MENU DO SISTEMA</h1>
				</td>
			</tr>
			<tr style="height:50px">
				<td colspan="2">
					Seja bem vindo(a)
				</td>
			</tr>
			<tr style="height:400px">
				<td colspan="2">
					<!-- TABELA QUE MOSTRA O MENU DO USUARIO -->
					<table style="height:400px;">
						<tr>
							<td style="width:150px; vertical-align:top;">
								<b>>> USU&Aacute;RIO</b></br>
								<a href="frmNovoUsuario.php">Novo usu&aacute;rio</a><br>
								<a href="frmListaNota.php">Gerenciar Usu&aacute;rios</a><br>
							</td>
							<td style="vertical-align:top; text-align:left;">
								<form method="post" action="frmNovaNota_processa.php" enctype="multipart/form-data">
									<table>
										<tr>
											<td colspan="2">
												<b>:: Novo Usu&aacute;rio ::</b>
											</td>
										</tr>
										<tr>
											<td>
												Nome:
											</td>
											<td>
												<input type="text" id="nome_cliente" name="nome_cliente" value="" required>
											</td>
										</tr>
										<tr>
											<td>
												Serviço:
											</td>
											<td>
												<input type="text" id="tipo_servico" name="tipo_servico" value="Pacote " required>
											</td>
										</tr>
										<tr>
											<td>
												Preço:
											</td>
											<td>
												<input type="text" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" id="preco" name="preco" required />
											</td>
										</tr>
										<tr>
											<td>
												Data:
											</td>
											<td>
												<input type="date" id="data" name="data" required>
											</td>
										</tr>
										<tr>
											<td>
												Forma De Pagamento:
											</td>
											<td>
												<?php
												$forma_pagamento = new clsFormaPagamento();
												$controles = new clsControlesHTML();
												echo $controles->geraSelect('slcFormaPagamento', $forma_pagamento->pegaFormaPagamento());
												?>
											</td>
										</tr>
										<tr>
											<td>
												Status de Pagamento:
											</td>
											<td>
												<?php
												$status = new clsStatus();
												$controles = new clsControlesHTML();
												echo $controles->geraSelect('slcStatus', $status->pegaStatus());
												?>
											</td>
										</tr>
										<tr>
											<td colspan="2" align="right">
												<button type="reset" name="btnApagar">Apagar</button>
												<button type="submit" name="btnSalvar">Cadastrar</button>
											</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>

	</html>
