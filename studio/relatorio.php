<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Notas Fiscais</title>
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

        .centralizar-tabela {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 20px;
        }

        .tabela {
            margin-top: 20px;
            width: 80%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .tabela th,
        .tabela td {
            font-weight: bold;
            color: #333;
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        .filtro-form {
            text-align: right;
            margin-bottom: 20px;
        }

        .filtro-form label {
            margin-right: 10px;
        }

        .filtro-form select,
        .filtro-form input[type="date"] {
            padding: 5px;
            border-radius: 5px;
        }

        .filtro-form button {
            background-color: dodgerblue;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filtro-form button:hover {
            background-color: deepskyblue;
        }

        .botao {
            background-color: black;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin: 15px;
        }

        .botao:hover {
            background-color: black;
        }
    </style>

</head>

<body>
    <header class="cabecalho">
        <h1 class="cabecalho-titulo">Relatório de Notas Fiscais</h1>
    </header>
    <div class="centralizar-tabela">
        <table border="3" class="tabela">
            <form class="filtro-form" method="get" action="">
                <input type="hidden" name="filtro_enviado" value="1"> <!-- Campo oculto para indicar que o formulário foi enviado -->
                <div class="campo">
                    <label for="data_inicio">Data Início:</label>
                    <input type="date" id="data_inicio" name="data_inicio" value="<?php echo $data_inicio; ?>" style="width: 200px; height:25px;">
                </div>
                <div class="campo">
                    <label for="data_fim">Data de Fim:</label>
                    <input type="date" id="data_fim" name="data_fim" value="<?php echo $data_fim; ?>" style="width: 200px; height: 25px;">
                </div>
                <button type="submit" class="botao-filtrar" style="width: 200px; height:25px;">Filtrar</button>
            </form>
            <tr>
                <th>Período</th>
                <th>Total de Notas</th>
                <th>Valor Total Pago</th>
                <th>Valor Total Não Pago</th>
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

            $data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : date('Y-m-d');
            $data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : date('Y-m-d', strtotime('+5 days'));

            if (isset($_GET['filtro_enviado'])) {
                if ($data_inicio > $data_fim) {
                    echo "<p style='color: red; font-size: 18px;'>Erro: Data de início não pode ser maior que a data de fim.</p>";
                } else {
                    $sql = "SELECT n.preco_nota, n.pago_nota, s.tipo_servico
        FROM tb_cliente AS c
        INNER JOIN tb_notas AS n ON c.id_cliente = n.id_cliente
        INNER JOIN tb_pagamento AS p ON n.id_pagamento = p.id_pagamento
        INNER JOIN tb_servico AS s ON n.id_servico = s.id_servico
        WHERE n.data_nota BETWEEN '$data_inicio' AND '$data_fim';
        ";
                    $result = $conn->query($sql);

                    $totalNotas = 0;
                    $totalPago = 0;
                    $totalNaoPago = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $totalNotas++;
                            if ($row["pago_nota"]) {
                                $totalPago += floatval($row["preco_nota"]);
                            } else {
                                $totalNaoPago += floatval($row["preco_nota"]);
                            }
                        }

                        echo "<tr>";
                        echo "<td>$data_inicio a $data_fim</td>";
                        echo "<td>$totalNotas</td>";
                        echo "<td>R$" . number_format($totalPago, 2) . "</td>";
                        echo "<td>R$" . number_format($totalNaoPago, 2) . "</td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='4'>Nenhum dado encontrado.</td></tr>";
                    }
                }
            }

            $conn->close();
            ?>
        </table>
        <a href="tabela.php" class="botao">Voltar para Tabela</a>
    </div>
</body>

</html>