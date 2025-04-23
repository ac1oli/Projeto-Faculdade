<?php
    require_once '../config.php';
    $mensagem = '';
    $conn = conectar_banco();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mensagem = cadastrar_usuario(
            $conn,
            $_POST['nome_completo'],
            $_POST['email'],
            $_POST['telefone'],
            $_POST['data_nascimento'],
            $_POST['senha'],
            $_POST['confirme_senha'],
            $_POST['cpf']
        );

        if ($mensagem === "Bem vindo!") {
            header("Location: loginteste.php"); 
            exit;
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="cadastro2.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Icon/logo.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <title>Cadastre-se</title>
</head>

<body>

    <div class="container">

        <img src="cadastro-login/image.png" alt="Logo">

        <h3>Cadastre-se</h3>

        <form action="/Inter/inter/Projeto/cadastroteste.php" method="POST">
            <fieldset>
                <legend>Informações para cadastro</legend>

                <div>
                    <label for="nome">Nome Completo:</label>
                    <input type="text" name="nome_completo" placeholder="Digite seu nome" id="nome" class="nome"
                        required>
                </div>

                <div>
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" placeholder="Digite seu e-mail" id="email" class="email" required>
                </div>

                <div>
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999" class="telefone"
                        required>
                </div>

                <div>
                    <label for="Data">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" id="Data" class="Data" required>
                </div>
                

                <div>
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" class="cpf" required>
                </div>

                <div>
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" placeholder="Digite sua senha" id="senha" class="senha"
                        required>
                </div>

                <div>
                    <label for="confirme">Confirme sua senha:</label>
                    <input type="password" name="confirme_senha" placeholder="Confirme sua senha" id="confirme"
                        class="senha" required>
                </div>

                <?php if (!empty($mensagem)): ?>
                    <div style="color: red;"><?php echo $mensagem; ?></div>
                <?php endif; ?>
            </fieldset>

            <div>
                <input type="submit" value="Enviar" class="submit"></input>
            </div>

        </form>


        <div class="login-link">
            <a href="login.html">Já tenho cadastro</a>
        </div>

        <div id="voltar">
            <a href="loginteste.php"> <img src="cadastro-login/voltar1.png" alt=""></a>
        </div>

    </div>

</body>

</html>