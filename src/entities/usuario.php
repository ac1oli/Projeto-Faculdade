<?php 
    require_once __DIR__ . '/../../config.php';

    function perfil_usuario() {
        if (!isset($_SESSION['usuario'])) {
            return "Nenhum usuário encontrado.";
        }

        $usuario = $_SESSION['usuario'];
        return "Perfil do Usuário:\nNome: {$usuario['nome']}\nData de Nascimento: {$usuario['data_nasc']}";
    }

    function listar_consultas_usuario($conn) {
        if (!isset($_SESSION['usuario'])) return "Usuário não logado.";
        
        $nome = $_SESSION['usuario']['nome'];
        $cursor = "SELECT * FROM consulta WHERE usuario = '$nome' AND status = 'agendado'";
        $resultado = $conn->query($cursor);
        
        if ($resultado->num_rows == 0) return "Nenhuma consulta agendada.";
        
        $html = "<ul>";
        while ($linha = $resultado->fetch_assoc()) {
            $html .= "<li>" . $linha['data'] . " às " . $linha['hora'] . "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

?>