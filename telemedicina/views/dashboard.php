<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
  <div class="wrapper">
    <aside class="sidebar">
      <div class="brand text-center">
        <img src="../assets/logo.png" alt="Logo Salves Health">
        <h2>Salves Health</h2>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li><a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i><span> Dashboard</span></a></li>
          <li><a href="cadastro_pacientes.php"><i class="fa-solid fa-user"></i><span> Pacientes</span></a></li>
          <li><a href="cadastro_medicos.php"><i class="fa-solid fa-user-doctor"></i><span> Médicos</span></a></li>
          <li><a href="cadastro_consultas.php"><i class="fa-solid fa-calendar-check"></i><span> Consultas</span></a></li>
          <li><a href="historico_medico_paciente.php"><i class="fa-solid fa-notes-medical"></i><span> Hist. Médico</span></a></li>
          <li><a href="historico_paciente_medico.php"><i class="fa-solid fa-notes-medical"></i><span> Hist. Paciente</span></a></li>
          <li><a href="cadastro_prontuario.php"><i class="fa-solid fa-file-medical"></i><span> Prontuários</span></a></li>
          <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i><span> Sair</span></a></li>
        </ul>
      </nav>
    </aside>
    <main class="main-content">
      <header class="main-header d-flex justify-content-between align-items-center">
        <h1>Dashboard</h1>
        <a href="logout.php" class="btn btn-outline-primary"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
      </header>
      <section class="content">
        <div class="card">
          <h3>Bem-vindo ao Salves Health</h3>
          <p>Gerencie todos os cadastros, consultas, históricos e prontuários com uma interface moderna e intuitiva.</p>
        </div>
      </section>
    </main>
  </div>
  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Salves Health. Todos os direitos reservados.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
