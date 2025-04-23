<?php
    require_once __DIR__ . '/../config.php';

    function login_usuario($conn, $email, $senha){

        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // garante que a sessão está ativa
        }

        if (!validar_email($email)) {
            return "E-mail inválido.";
        }

        // Buscando o CPF junto com a senha
        $stmt = $conn->prepare("SELECT cpf, nome, email, senha, telefone FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            $senha_cript = $usuario['senha'];

            if (validar_senha_usuario($senha, $senha_cript)) {
                // Salvando o CPF na sessão
                $_SESSION['usuario'] = [
                    'cpf' => $usuario['cpf'],       // este será usado como usuario_fk
                    'nome' => $usuario['nome'],
                    'email' => $usuario['email'],
                    'telefone' => $telefone['telefone']
                ];

                return "Login realizado com sucesso!";
            } else {
                return "Senha incorreta.";
            }
        } else {
            return "Usuário não cadastrado.";
        }
    }

    function login_nutricionista($conn, $email, $senha, $crn){
        if (empty($crn) || empty($senha) || empty($email)) {
            return "Preencha todos os campos.";
        }

        if (!validar_email($email)) {
            return "E-mail inválido.";
        }

        if (!validar_crn($crn)) {
            return "CRN inválido.";
        }

        $stmt = $conn->prepare("SELECT senha FROM nutricionista WHERE crn = ?");
        $stmt->bind_param("s", $crn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $nutricionista = $result->fetch_assoc();
            $senha_cript = $nutricionista['senha'];

            return validar_senha_usuario($senha, $senha_cript)
                ? "Login realizado com sucesso!"
                : "Senha incorreta.";
        } else {
            return "CRN não cadastrado.";
        }
    }
?>
