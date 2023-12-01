<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];


    if (!empty($usuario) && !empty($senha)) {

        if ($usuario === 'admin' && $senha === 'admin') {

            $_SESSION['usuario'] = $usuario;
            header('Location: tabela.php');
            exit();
        } else {
            echo '<h1>Credenciais inválidas. Tente novamente.</h1>';
        }
    } else {
        echo '<h1>Por favor, preencha todos os campos.</h1>';
    }
}
?>

<head>
    <meta charset="UTF-8" />
    <title>Tela de login</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: cyan;
            text-align: center;
        }

        .div {
            background-color: black;
            padding: 80px;
            border-radius: 15px;
            color: #fff;
            display: inline-block;
            margin-top: 12%;
        }

        input {
            padding: 15px;
            border: none;
            outline: none;
            font-size: 15px;
        }

        .button {
            background-color: dodgerblue;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 15px;
        }

        .button:hover {
            background-color: deepskyblue;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <div class="div">
            <h1>Login</h1>
            <input type=" text" id="usuario" name="usuario" placeholder="Usuário" />
            <br /><br />
            <input type="password" id="senha" name="senha" placeholder="Senha" />
            <br /><br />
            <input type="submit" class="button" value="Entrar"></input>
        </div>
    </form>
</body>

</html>