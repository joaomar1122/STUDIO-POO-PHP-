<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Notas</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: cyan;
            margin: 0;
            padding: 0;
        }

        .cabecalho {
            background-color: rgba(0, 0, 0, 0.9);
            color: #fff;
            text-align: left;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cabecalho-titulo {
            margin: 0;
        }

        .botao-cadastro {
            background-color: dodgerblue;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .botao-cadastro:hover {
            background-color: deepskyblue;
        }

        .tabela {
            margin: 30px auto;
            border-collapse: collapse;
            width: 80%;
        }

        .tabela th,
        .tabela td {
            font-weight: bold;
            color: #333;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        .centralizar-tabela {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .filtro-form {
            text-align: right;
            margin-bottom: 20px;
        }

        .filtro-form label {
            margin-right: 10px;
        }

        .filtro-form select {
            padding: 5px;
            border-radius: 5px;
        }

        .botao {
            background-color: black;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 10px;
        }


        .botao:hover {
            background-color: black;
        }
    </style>
</head>

<body>
    <header class="cabecalho">
        <h1 class="cabecalho-titulo">Gerir Notas Fiscais</h1>
        <a href="cadastro.php" class="botao-cadastro">Cadastrar Nova Nota Fiscal</a>
    </header>

    <div class="centralizar-tabela">
        <form class="filtro-form" method="get" action="">
            <label for="filtro_status_pagamento">Filtrar por Status de Pagamento:</label>
            <select id="filtro_status_pagamento" name="filtro_status_pagamento">
                <option value="">Todos</option>
                <option value="pago">Pago</option>
                <option value="nao_pago">Não Pago</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        <table border="3" class="tabela">
            <tr>
                <th>Nome</th>
                <th>Servi&ccedil;os</th>
                <th>Pre&ccedil;o</th>
                <th>Data</th>
                <th>Forma de Pagamento</th>
                <th>Pago Ou N&atilde;o</th>
                <th>Ações</th>
                <th>Editar</th>
            </tr>
            <?php
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname = 'bd_notas';

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Falha na conexão com o banco de dados: " . $conn->connect_error);
            }


            $filter = "";

            if (isset($_GET['filtro_status_pagamento']) && $_GET['filtro_status_pagamento'] !== "") {
                $filtro_status_pagamento = $_GET['filtro_status_pagamento'] === 'pago' ? 1 : 0;
                $filter .= " AND pago_nota = $filtro_status_pagamento";
            }

            $sql = "SELECT n.id_notas, c.nome_cliente, n.data_nota, n.preco_nota, n.pago_nota, p.forma_pagamento, s.tipo_servico 
            FROM tb_cliente as c, tb_notas as n, tb_pagamento as p, tb_servico as s
            WHERE (c.id_cliente = n.id_cliente)
            AND (p.id_pagamento = n.id_pagamento)
            AND (s.id_servico = n.id_servico) $filter
            ORDER BY n.id_notas";

            $result = $conn->query($sql);


            $totalpago = 0;
            $totalnaopago = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row["pago_nota"]) {
                        echo "<tr>";
                        echo "<td>" . $row["nome_cliente"] . "</td>";
                        echo "<td>" . $row["tipo_servico"] . "</td>";
                        echo "<td>" . "R$" . $row["preco_nota"] . "</td>";
                        echo "<td>" . $row["data_nota"] . "</td>";
                        echo "<td>" . $row["forma_pagamento"] . "</td>";
                        echo "<td>Pago</td>";
                        echo '<td><a href="excluir.php?id=' . $row['id_notas'] . '" class="botao-excluir">Excluir</a></td>';
                        echo '<td>';
                        if (!$row['pago_nota']) {
                            echo '<a href="editar.php?id=' . $row['id_notas'] . '" class="botao-editar">Pago</a>';
                        }
                        echo '</td>';
                        echo "</tr>";

                        $totalpago += floatval($row["preco_nota"]);
                    } else {
                        echo "<tr>";
                        echo "<td>" . $row["nome_cliente"] . "</td>";
                        echo "<td>" . $row["tipo_servico"] . "</td>";
                        echo "<td>" . "R$" . $row["preco_nota"] . "</td>";
                        echo "<td>" . $row["data_nota"] . "</td>";
                        echo "<td>" . $row["forma_pagamento"] . "</td>";
                        echo "<td>Não Pago</td>";
                        echo '<td><a href="excluir.php?id=' . $row['id_notas'] . '" class="botao-excluir">Excluir</a></td>';
                        echo '<td>';
                        if (!$row['pago_nota']) {
                            echo '<a href="editar.php?id=' . $row['id_notas'] . '" class="botao-editar">Pago</a>';
                        }
                        echo '</td>';

                        $totalnaopago += floatval($row["preco_nota"]);
                    }
                }


                echo "<tr>";
                echo "<td colspan='5'><strong>Total Pago:</strong></td>";
                echo "<td><strong>R$" . number_format($totalpago, 2) . "</strong></td>";
                echo "</tr>";


                echo "<tr>";
                echo "<td colspan='5'><strong>Total Não Pago:</strong></td>";
                echo "<td><strong>R$" . number_format($totalnaopago, 2) . "</strong></td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='6'>Nenhum dado encontrado.</td></tr>";
            }

            $conn->close();
            ?>
        </table>
        <a href="relatorio.php" class="botao">Gerar Relatório</a>
        <a href="logout.php" class="btn">LOGOUT</a>
    </div>
</body>

</html>