<?php
    require_once 'config.php'; // ou 'database/conexao.php' se for lá que está
?>    

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Login</title>
</head>
<body>

    <?php
        $conn = conectar_banco();
        $tipo_formulario = $_POST['tipo_formulario'] ?? '';

        switch ($tipo_formulario) {
            case 'cadastro':
                $msg_cadastro = cadastrar_usuario(
                    $conn,
                    $_POST['nome_completo'],
                    $email = $_POST['email'],
                    $_POST['telefone'],
                    $_POST['data_nascimento'],
                    $senha = $_POST['senha'],
                    $_POST['confirme_senha'],
                    $_POST['cpf']
                );
                echo $msg_cadastro . "<br>";
                break;

            case 'login':
                $email = $_POST['email'] ?? '';
                $senha = $_POST['senha'] ?? '';
                $msg_login = login_usuario($conn, $email, $senha);
                echo $msg_login . "<br>";
                break;


            case 'consulta':

                $data = date('Y-m-d', strtotime($_POST['data_consulta']));
                $hora = date('H:i:s', strtotime($_POST['data_consulta']));
                
                $msg_consulta = agendar_consulta($conn, $data, $hora);
                echo $msg_consulta;
                break;

            default:
                echo "Verifique o tipo do formulário.<br>";
                break;
        }

        $conn->close();
    ?>
</body>
</html>
