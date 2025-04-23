<?php
    
    require_once __DIR__ . '/../config.php';
    
    function cadastrar_usuario($conn, $nome, $email, $telefone, $data_nasc, $senha, $confirm_senha, $cpf){
        if (empty($cpf) || empty($nome) || empty($telefone) || empty($email) || empty($data_nasc) || empty($senha) || empty($confirm_senha)) {
            return "Preencha todos os campos.";
        }

        if($senha !== $confirm_senha){
            return "As senhas não coincidem.";
        }

        if(!idade($data_nasc)){
            return "Data de nascimento inválida.";
        }

        if (!validar_cpf($cpf)) {
            return "CPF inválido.";
        }

        if (!validar_telefone($telefone)){
            return "Telefone inválido.";
        }

        if (!validar_email($email)){
            return "E-mail inválido.";
        }

        $cursor = "select cpf from usuario where cpf = '$cpf'";
        $registro = $conn->query($cursor);

        if($registro->num_rows > 0){
            return "Usuário já cadastrado.";
        }

        $cursor = "select email from usuario where email = '$email'";
        $registro = $conn->query($cursor);

        if($registro->num_rows > 0){
            return "E-mail já cadastrado.";
        }

        $senha_cript = password_hash($senha, PASSWORD_DEFAULT);
        $nome_title = ucwords(strtolower($nome)); 
        $idade = idade($data_nasc);

        $cursor = "insert into usuario (cpf, nome, telefone, senha, email, data_nasc, idade) values ('$cpf', '$nome_title', '$telefone', '$senha_cript', '$email', '$data_nasc', '$idade')";
   
        if ($conn->query($cursor)) {
            $_SESSION['usuario'] = [
                'nome' => $nome_title,
                'data_nasc' => $data_nasc,
                'cpf' => $cpf,
                'email' => $email,
                'telefone' => $telefone
            ];
            return "Bem vindo!";
        } else {
            return "Erro ao cadastrar usuário: " . $conn->error;
        }
    }

    function cadastrar_nutricionista($conn, $nome, $email, $telefone, $senha, $confirm_senha, $crn){
        if (empty($crn) || empty($nome) || empty($telefone) || empty($email) || empty($senha) || empty($confirm_senha)) {
            return "Preencha todos os campos.";
        }

        if($senha !== $confirm_senha){
            return "As senhas não coincidem.";
        }
        
        if (!validar_telefone($telefone)){
            return "Telefone inválido.";
        }

        if (!validar_email($email)){
            return "E-mail inválido.";
        }

        $cursor = "select crn from nutricionista where crn = '$crn'";
        $registro = $conn->query($cursor);

        if($registro->num_rows > 0){
            return "Nutricionista já cadastrado.";
        }

        $cursor = "select email from usuario where email = '$email'";
        $registro = $conn->query($cursor);

        if($registro->num_rows > 0){
            return "E-mail já cadastrado.";
        }

        $senha_cript = password_hash($senha, PASSWORD_DEFAULT);
        $nome_title = ucwords(strtolower($nome)); 

        $cursor = "insert into nutricionista (nome, telefone, senha, email) values ('$nome_title', '$telefone', '$senha_cript', '$email')";
   
        return $conn->query($cursor) ? "Bem vindo, $nome_title!" : "Erro ao cadastrar usuário: " . $conn->error;
    }
?>