<?php
    require_once __DIR__ . '/../../config.php';

    function validar_telefone($telefone){
        $telefone = preg_replace('/\D/', '', $telefone);

        if(strlen($telefone) < 10 || strlen($telefone) > 11){
            return false;
        }

        if(strlen($telefone) === 11){ 
            return '(' . substr($telefone, 0, 2) . ')' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
        } else {
            return '(' . substr($telefone, 0, 2) . ')' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
        }
    }
   
    function validar_cpf($cpf){
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

    function idade($data_nasc) {
        if (!$data_nasc) {
            return "Data de nascimento vazia.";
        }
    
        $nasc = DateTime::createFromFormat('Y-m-d', $data_nasc);
        $atual = new DateTime();
    
        if (!$nasc || $nasc > $atual) {
            return false;
        }
    
        $idade = $atual->diff($nasc)->y;
        return $idade;
    }

    function validar_crn($crn) {

        $crn = preg_replace('/[^0-9]/', '', $crn);
    
        if (strlen($crn) < 6 || strlen($crn) > 8) {
            return false; 
        }
    
        $regiao = substr($crn, 0, 2);
        $registro = substr($crn, 2);
    
        return "CRN-{$regiao}/{$registro}";
    }
    

    function validar_senha_usuario($senha, $senha_cript){
        return password_verify($senha, $senha_cript);
    }

    function validar_email($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function verificar_disponibilidade($conn, $data_consulta, $hora) {
        
        $cursor = "select * from consulta where data = '$data_consulta' and status = 'disponivel' and '$hora' = hora";
        $registro = $conn->query($cursor);
    
        if ($registro->num_rows > 0) {
            return false;  // horario ocupado
        }
        return true;  // horario disponivel
    }

?>