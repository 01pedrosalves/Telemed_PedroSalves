<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Login - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>

<?php
session_start();
require_once "../config.php";

$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $login_input = trim($_POST["login"] ?? "");
  $senha_input = trim($_POST["senha"] ?? "");
  $senha_hashed = md5($senha_input);  
  
  $stmt = $conn->prepare("SELECT * FROM tbusuarios WHERE login = :login");
  $stmt->bindParam(":login", $login_input);
  $stmt->execute();
  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if ($usuario && $senha_hashed === $usuario["senha"]) {
    $_SESSION["usuario"] = $usuario["usuario"];
    header("Location: dashboard.php");
  } else {
    $erro = "Login ou senha inválidos.";
  }
}
?>
  <div class="login-page">
    <div class="login-box">
    <img src="../assets/logo.png" alt="Logo Salves Health" class="logo">
    <h2><i class="fa-solid fa-user-lock"></i> Login</h2>
      <?php if (!empty($erro)) { echo "<p class='error'>$erro</p>"; } ?>
      <form method="POST">
        <div class="input-group">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="login" placeholder="Digite seu login" required>
        </div>
        <div class="input-group">
          <i class="fa-solid fa-lock"></i>
          <input type="password" name="senha" placeholder="Digite sua senha" required>
        </div>
        <a href="http://http://salves.infinityfreeapp.com/telemedicina/views/dashboard.php">
        <button type="submit"><i class="fa-solid fa-arrow-right"></i> Entrar</button>

        </a>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
