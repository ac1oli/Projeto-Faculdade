<?php
    function conectar_banco() {
        $host = 'localhost';
        $usuario = 'root';
        $senha = '';
        $db_name = 'nutrisync';
        $conn = new mysqli($host, $usuario, $senha, $db_name);

        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        return $conn;
    }
   
?>