<html>

<head>
	<title>SISTEMA DE NOTAS FISCAIS</title>
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
				<h1>SISTEMA DE GERENCIMENTO DE NOTAS FISCAIS</h1>
			</td>
		</tr>
		<tr style="height:50px">
			<td colspan="2">
				Seja bem vindo(a)!
			</td>
		</tr>
		<tr style="height:400px">
			<td colspan="2">
				<!-- TABELA QUE MOSTRA O MENU DO USUARIO -->
				<table style="height:400px;">
					<tr>
						<td style="width:150px; vertical-align:top;">
							<a href="frmNovaNota.php">Nova Nota</a><br>
							<a href="frmListaNota.php">Gerenciar Notas</a><br>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>
