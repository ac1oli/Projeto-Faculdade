<?php
require_once '../config.php';
$conn = conectar_banco();

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $confirme_senha = $_POST['confirme_senha'];

    $mensagem = esqueci_senha($conn, $cpf, $senha, $confirme_senha);

    if($mensagem === "Senha atualizada com sucesso!"){
        header("Location: loginteste.php"); 
        exit;
    }
}

function esqueci_senha($conn, $cpf, $senha, $confirme_senha) {
    if ($senha !== $confirme_senha) {
        return "As senhas não coincidem.";
    }

    // Verifica se o usuário com o CPF existe
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "Usuário não encontrado.";
    }

    // Atualiza a senha (use hash segura como password_hash em produção!)
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuario SET senha = ? WHERE cpf = ?");
    $stmt->bind_param("ss", $senha_hash, $cpf);
    
    if ($stmt->execute()) {
        return "Senha atualizada com sucesso!";
    } else {
        return "Erro ao atualizar a senha.";
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

    
    <title>Esqueci Minha Senha</title>
</head>

<body>

    <div class="container">

        <img src="cadastro-login/image.png" alt="Logo">

        <h3>Alterar Senha</h3>

        <form action="/Inter/inter/Projeto/esquecisenha.php" method="POST">
            <fieldset>
                
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

        <div id="voltar">
            <a href="loginteste.php"> <img src="cadastro-login/voltar1.png" alt=""></a>
        </div>

    </div>

</body>

</html>