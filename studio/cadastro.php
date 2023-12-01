    <?php

    session_start();


    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'bd_notas';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome_cliente =  $_POST['nome_cliente'];
        $tipo_servico = $_POST['tipo_servico'];


        $preco_nota = str_replace(',', '.', $_POST['preco']); //substituir vírgulas por pontos no preço
        if (!is_numeric($preco_nota)) {
            die("Erro: Preço inválido.");
        }

        $data_nota = $_POST['data'];

        $pago_nota = false;
        if (isset($_POST['pago_nota']) && $_POST['pago_nota'] === 'on') {
            $pago_nota = true;
        }

        $formaPagamentoID = [
            "Cartão de Crédito" => 1,
            "Dinheiro" => 4,
            "Pix" => 3,
            "Cartão de Debito" => 2,
        ];

        if (isset($_POST['forma_pagamento'])) {
            $forma_pagamento = $_POST['forma_pagamento'];
            $id_pagamento = $formaPagamentoID[$forma_pagamento];
        } else {
            die("Erro: Forma de pagamento inválida.");
        }


        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        $sql = "INSERT INTO tb_cliente (nome_cliente) VALUES ('$nome_cliente')";
        $conn->query($sql);


        $id_cliente = $conn->insert_id;


        $sql = "INSERT INTO tb_servico (tipo_servico) VALUES ('$tipo_servico')";
        $conn->query($sql);


        $id_servico = $conn->insert_id;


        $sql = "INSERT INTO tb_notas (data_nota, pago_nota, preco_nota, id_pagamento, id_cliente, id_servico)
                VALUES ('$data_nota', '$pago_nota', '$preco_nota', '$id_pagamento', '$id_cliente', '$id_servico')";

        if ($conn->query($sql) === true) {
            header('Location: tabela.php');
        } else {
            echo "Erro ao inserir dados: " . $conn->error;
        }

        $conn->close();
    }
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Notas Fiscais</title>
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
                text-align: center;
                padding: 20px;
            }

            .cabecalho-titulo {
                margin: 0;
            }

            .formulario {
                background-color: rgba(0, 0, 0, 0.9);
                color: #fff;
                padding: 40px;
                border-radius: 10px;
                margin: 30px auto;
                width: 60%;
            }

            .campo {
                margin-bottom: 10px;
            }

            .campo label {
                display: block;
                margin-bottom: 5px;
            }

            .campo input {
                padding: 10px;
                width: 100%;
                border: none;
                border-radius: 5px;
                font-size: 14px;
            }

            .botao {
                background-color: dodgerblue;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .botao:hover {
                background-color: deepskyblue;
            }

            .campo select {
                padding: 10px;

                width: 75%;
                border: none;
                border-radius: 5px;
                font-size: 14px;
            }

            .campo input[type="checkbox"] {
                transform: scale(1.5);
                margin-right: 5px;
            }


            .botao_voltar {
                background-color: dodgerblue;
                color: white;
                padding: 5px 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                margin: 15px;
                font-family: Arial, Helvetica, sans-serif
            }

            .botao_voltar:hover {
                background-color: deepskyblue;
            }
        </style>
    </head>

    <body>
        <header class="cabecalho">
            <h1 class="cabecalho-titulo">Cadastro de Notas Fiscais</h1>
        </header>
        <center>
            <div class="formulario">
                <form id="nota-form" method="post" action="cadastro.php" enctype="multipart/form-data">
                    <div class="campo">
                        <label for="nome_cliente">Nome:</label>
                        <input type="text" id="nome_cliente" name="nome_cliente" value="" required>
                    </div>
                    <div class="campo">
                        <label for="tipo_servico">Serviço:</label>
                        <input type="text" id="tipo_servico" name="tipo_servico" value="Pacote " required>
                    </div>
                    <div class="campo">
                        <label for="preco">Preço:</label>
                        <input type="text" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" id="preco" name="preco" required />
                    </div>
                    <div class="campo">
                        <label for="data">Data:</label>
                        <input type="date" id="data" name="data" required>
                    </div>
                    <div class="campo">
                        <label for="forma_pagamento">Forma de Pagamento:</label>
                        <select id="forma_pagamento" name="forma_pagamento" required>
                            <option value="" disabled selected>Selecione...</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Pix">Pix</option>
                        </select>
                    </div>
                    <div class="campo">
                        <label for="pago">Pago:</label>
                        <input type="checkbox" id="pago_nota" name="pago_nota">
                    </div>
                    <button type="submit" class="botao">Cadastrar</button>
                    <br>
                    <br>
                    <a href="tabela.php" class="botao_voltar">Voltar para Tabela</a>
                </form>
            </div>
        </center>
    </body>

    </html>
