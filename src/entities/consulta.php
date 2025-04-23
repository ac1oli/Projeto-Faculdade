<?php
    require_once __DIR__ . '/../../config.php';

    function agendar_consulta($conn, $data_consulta, $hora) {
        if (!isset($_SESSION['usuario'])) {
            return 'Nenhum usuário logado.';
        }
    
        // Data e hora atual
        $data_atual = new DateTime();  // Data e hora atual
        $data_consulta_obj = DateTime::createFromFormat('Y-m-d H:i', $data_consulta . ' ' . $hora); // Criar um objeto DateTime combinando data e hora
        
        // Se a data e hora da consulta for no passado
        if ($data_consulta_obj < $data_atual) {
            return 'Não é possível agendar uma consulta em uma data e horário que já passaram.';
        }
    
        // Se a data for o mesmo dia, verificar o horário
        if ($data_consulta_obj->format('Y-m-d') === $data_atual->format('Y-m-d')) {
            $hora_atual = $data_atual->format('H:i'); // Hora atual no formato de 24 horas
            
            // Se a hora da consulta for menor ou igual à hora atual, não pode agendar
            if ($hora <= $hora_atual) {
                return 'Não é possível agendar uma consulta no horário que já passou.';
            }
        }
    
        // Verificar disponibilidade do horário (se já está agendado)
        $usuario_cpf = $_SESSION['usuario']['cpf'];
        if (!verificar_disponibilidade($conn, $data_consulta, $hora)) {
            return 'Horário já ocupado. Por favor, escolha outro horário.';
        }
    
        // Inserir consulta no banco de dados
        $cursor = "INSERT INTO consulta (usuario_fk, data, status, hora) 
                   VALUES ('$usuario_cpf', '$data_consulta', 'agendado', '$hora')";
        
        if ($conn->query($cursor)) {
            // Sessão com dados da consulta agendada
            $_SESSION['ultima_consulta'] = [
                'data' => $data_consulta,
                'hora' => $hora
            ];
            return "Consulta agendada!";
        } else {
            return "Erro ao agendar consulta: " . $conn->error;
        }
    }
    function cancelar_consulta($conn, $cpf, $data, $hora) {
        $stmt = $conn->prepare("UPDATE consulta SET status = 'cancelada' WHERE usuario_fk = ? AND data = ? AND hora = ?");
        $stmt->bind_param("sss", $cpf, $data, $hora);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return "Consulta cancelada com sucesso.";
        } else {
            return "Não foi possível cancelar a consulta.";
        }
    }
?>
