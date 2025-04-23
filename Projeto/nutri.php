<?php
session_start();
require_once '../config.php';

// Conectar ao banco de dados
$conn = conectar_banco();

// Assumindo que o nutricionista está logado (por exemplo, você pode usar o ID do nutricionista ou um CPF)
$nutricionista_id = $_SESSION['usuario']['id'] ?? '';  // Ou use o 'cpf' se necessário

// Buscar consultas do nutricionista para o dia atual
$consultas_do_dia = [];
$consultas_da_semana = [];

if ($nutricionista_id) {
    $stmt = $conn->prepare("SELECT c.data, c.hora, u.nome 
                            FROM consulta c
                            JOIN usuario u ON c.usuario_fk = u.cpf 
                            WHERE c.nutricionista_fk = ? AND c.status = 'agendado'
                            ORDER BY c.data, c.hora");
    $stmt->bind_param("s", $nutricionista_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Separar as consultas para o dia atual e para a semana
    $data_atual = new DateTime();
    $data_inicio_semana = clone $data_atual;
    $data_inicio_semana->modify('monday this week');  // Começo da semana

    while ($row = $result->fetch_assoc()) {
        $data_consulta = DateTime::createFromFormat('Y-m-d', $row['data']);
        $hora_consulta = $row['hora'];
        $nome_paciente = $row['nome'];

        if ($data_consulta->format('Y-m-d') === $data_atual->format('Y-m-d')) {
            // Consultas do dia
            $consultas_do_dia[] = ['hora' => $hora_consulta, 'paciente' => $nome_paciente];
        }

        // Consultas da semana (de segunda até domingo)
        if ($data_consulta >= $data_inicio_semana && $data_consulta <= $data_inicio_semana->modify('sunday this week')) {
            $consultas_da_semana[] = ['data' => $data_consulta->format('d/m/Y'), 'hora' => $hora_consulta, 'paciente' => $nome_paciente];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil do Nutricionista - Nutrisync</title>
  <link rel="stylesheet" href="nutri1.css">
  <link rel="shortcut icon" href="Icon/logo.ico" type="image/x-icon">
</head>
<body>

  <nav class="navbar">
    <ul>
      <li><a href="nutri.php" class="active">Meu Perfil</a></li>
      <li><a href="diaC.html">Consultas</a></li>
      <li><a href="index.html">Sair</a></li>
    </ul>
  </nav>

  <div class="container">
    <img src="cadastro-login/image.png" alt="Logo Nutrisync" class="logo" />
    <h1>Perfil do Nutricionista</h1>
    <h3>Alexsandro</h3>

    <div class="section">
      <h2>Formação Acadêmica</h2>
      <p>🎓 Nutricionista graduado(a) pela <strong>UNINASSAU</strong></p>
    </div>

    <div class="section">
      <h2>Certificações</h2>
      <ul>
        <li>📜 Certificação em Nutrição Esportiva</li>
        <li>📜 Curso de Atualização em Dieta Vegana</li>
        <li>📜 Dietas Low Carb</li>
      </ul>
    </div>

    <div class="section">
      <h2>Experiência Profissional</h2>
      <p>10 anos de experiência em:</p>
      <ul>
        <li>Consultórios particulares</li>
        <li>Clínicas de saúde</li>
        <li>Nutrição infantil</li>
        <li>Atendimento esportivo</li>
      </ul>
    </div>

  </div>
</body>
</html>
