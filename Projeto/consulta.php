<?php
  session_start();
  require_once '../config.php';
  $mensagem = '';
  $conn = conectar_banco();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // quando realizar o login salvar o nome
    $data = $_POST['data'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $mensagem = agendar_consulta($conn, $data, $horario);

    if ($mensagem === "Consulta agendada!") {
      header("Location: usuario.php");
      exit;
    }
  } 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Agendamento de Consulta</title>
  <link rel="shortcut icon" href="Icon/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="consulta1.css">

</head>
<body>
  <div class="container">
    <img src="cadastro-login/image.png" alt="Logo" class="Logo">
    <h1>Agende sua Consulta</h1>
    <form method="POST" action="/Inter/inter/Projeto/consulta.php">
      <label for="data">Data da consulta</label>
      <input type="date" id="data" name="data" class="idade" required>

      <label for="horario">Horário</label>
      <select id="horario" name="horario" class="horas" required>
        <option value="">Selecione um horário</option>
        <option value="08:00">08:00</option>
        <option value="10:00">10:00</option>
        <option value="14:00">14:00</option>
        <option value="16:00">16:00</option>
      </select>

      <label for="mensagem">Observações</label>
      <textarea id="mensagem" name="mensagem" rows="4"></textarea>
      <?php if (!empty($mensagem)): ?>
        <div style="color: red;"><?php echo $mensagem; ?></div>
      <?php endif; ?>

      <button name="agendar" type="submit">Agendar</button>

    </form>
  </div>
</body>
</html>
