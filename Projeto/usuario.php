<?php
session_start();
require_once '../config.php';

$conn = conectar_banco();
$cpf = $_SESSION['usuario']['cpf'] ?? '';
$mensagem = '';  // Para exibir mensagens, caso necessário

// Buscar consultas do usuário logado
$consultas = [];
if ($cpf) {
    $stmt = $conn->prepare("SELECT id, data, hora FROM consulta WHERE usuario_fk = ? AND status = 'agendado' ORDER BY data, hora");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $consultas[] = $row;
    }
}

// Cancelar consulta
if (isset($_GET['cancelar_id'])) {
    $consulta_id = $_GET['cancelar_id'];
    $stmt = $conn->prepare("UPDATE consulta SET status = 'cancelado' WHERE id = ? AND usuario_fk = ?");
    $stmt->bind_param("is", $consulta_id, $cpf);
    
    if ($stmt->execute()) {
        $mensagem = "Consulta cancelada com sucesso.";
    } else {
        $mensagem = "Erro ao cancelar consulta.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Meu Perfil - Nutrisync</title>
  <link rel="shortcut icon" href="Icon/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="usuario2.css">
</head>

<body>
  
  <nav class="navbar">
    <ul>
      <li><a href="perfil.html" class="active">Meu Perfil</a></li>
      <li><a href="consulta.php">Agendar</a></li>
      <li><a href="index.html">Sair</a></li>
    </ul>
  </nav>

  
  <div class="container">
    <img src="cadastro-login/image.png" alt="Logo Nutrisync" class="logo" />
    <h1>Meu Perfil</h1>

    <div class="section">
      <h2>Informações do Usuário</h2>
      <p><strong>Nome:</strong> <?php echo $_SESSION['usuario']['nome'] ?></p>
      <p><strong>E-mail:</strong> <?php echo $_SESSION['usuario']['email'] ?></p>
    </div>

    <div class="section">
      <h2>Consultas</h2>

      <?php if (!empty($consultas)): ?>
        <?php foreach ($consultas as $consulta): ?>
          <p>📅 
            <?php
              $data = DateTime::createFromFormat('Y-m-d', $consulta['data']);
              echo $data->format('d/m/Y') . ' às ' . $consulta['hora'];
            ?>
          </p>
          <!-- Botão para Cancelar -->
          <button class="cancel-btn" onclick="window.location.href='usuario.php?cancelar_id=<?php echo $consulta['id']; ?>'">
            Cancelar
          </button>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Nenhuma consulta agendada ainda.</p>
      <?php endif; ?>

      <button class="link-btn" onclick="window.location.href='consulta.php'">+ Marcar nova consulta</button>
    </div>

    <?php if (!empty($mensagem)): ?>
      <div style="color: red;"><?php echo $mensagem; ?></div>
    <?php endif; ?>

  </div>

</body>
</html>
