<?php
    require_once '../config.php';
    $mensagem = '';
    $conn = conectar_banco();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // quando realizar o login salvar o nome
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $nome = '';
        $mensagem = login_usuario($conn, $email, $senha);

        if ($mensagem === "Login realizado com sucesso!") {
            header("Location: usuario.php"); 
            exit;
        }

        if($_POST['email'] === "alexsandro.nutri@gmail.com" and $_POST['senha'] === "cunibra"){
            header("Location: nutri.php"); 
            exit;
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login2.css">
    <link rel="shortcut icon" href="Icon/logo.ico" type="image/x-icon">
    <title>Logar</title>
</head>
<body>

    <div class="container">

     <img src="cadastro-login/image.png" alt="Logo">
     
     <form method= "POST" action= "/Inter/inter/Projeto/loginteste.php">

        <h3>Entrar em sua conta</h3>

        <div class="box">
          <input type="email" name= "email" placeholder="Digite seu e-mail" id="email" class="email" required>
        </div>

        <div class="box">
            <input type="password" name="senha" placeholder="Digite sua senha" id="senha" class="senha" required>
        </div>
        <?php if (!empty($mensagem)): ?>
            <div style="color: red;"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <div class="relembrar">

            <label>

            <input type="checkbox">
            Lembrar senha

            </label>

            <a href="esquecisenha.php">Esqueci a senha</a>

        </div>

        <div>
            <input type="submit" value="Login" class="submit"></input>
        </div>

        <div class="registro">
            <P>Não tem uma conta? <a href="cadastroteste.php">Cadastre-se</a></P>
        </div>

        <div class="voltar">
            <a href="index.html"><img src="cadastro-login/voltar1.png" alt=""></a>
        </div>

     </form>

    </div>



</body>
</html>