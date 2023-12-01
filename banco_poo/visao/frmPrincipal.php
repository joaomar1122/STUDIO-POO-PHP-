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
					<h1>SISTEMA POO</h1>
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
								<a href="frmNovoUsuario.php">Novo usu&aacute;rio</a><br>
								<a href="frmListaUsuario.php">Gerenciar Usu&aacute;rios</a><br>

							</td>
							<td style="vertical-align:middle; text-align:center;">
								NENHUM CADASTRO SELECIONADO NO MOMENTO
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
