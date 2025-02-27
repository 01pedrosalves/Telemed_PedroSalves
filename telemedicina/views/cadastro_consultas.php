<?php
session_start();

require_once "../config.php";

$stmtMedicos = $conn->prepare("SELECT medico, nome FROM tbmedicos");
$stmtMedicos->execute();
$medicos = $stmtMedicos->fetchAll(PDO::FETCH_ASSOC);

$stmtPacientes = $conn->prepare("SELECT paciente, nome FROM tbpacientes");
$stmtPacientes->execute();
$pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Consultas - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
      <header class="main-header">
        <h1>Agendamento de Consultas</h1>
      </header>
      <section class="content">
        <div id="msgConsulta"></div>
        <form id="formConsulta" method="POST" class="mb-4">
          <div class="mb-3">
            <select name="medico" class="form-select" required>
              <option value="">Selecione um Médico</option>
              <?php foreach($medicos as $medico): ?>
              <option value="<?php echo $medico["medico"]; ?>"><?php echo $medico["nome"]; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <select name="paciente" class="form-select" required>
              <option value="">Selecione um Paciente</option>
              <?php foreach($pacientes as $paciente): ?>
              <option value="<?php echo $paciente["paciente"]; ?>"><?php echo $paciente["nome"]; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <input type="date" name="data" class="form-control" required>
          </div>
          <div class="mb-3">
            <input type="time" name="horario" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Agendar Consulta</button>
        </form>
        <hr>
        <h4>Consultas Agendadas</h4>
        <div id="listaConsultas">
          <?php include '../assets/ajax/lista_consultas.php'; ?>
        </div>
      </section>
    </main>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function(){
      const formConsulta = document.getElementById("formConsulta");
      formConsulta.addEventListener("submit", function(e){
        e.preventDefault();
        const formData = new FormData(formConsulta);
        fetch("../assets/ajax/cadastrar_consulta.php", {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          const msgDiv = document.getElementById("msgConsulta");
          if(data.success) {
            msgDiv.innerHTML = "<div class='alert alert-success'>Consulta agendada com sucesso!</div>";
            formConsulta.reset();
            fetch("../assets/ajax/lista_consultas.php")
              .then(resp => resp.text())
              .then(html => { document.getElementById("listaConsultas").innerHTML = html; });
          } else {
            msgDiv.innerHTML = "<div class='alert alert-danger'>" + data.message + "</div>";
          }
        })
        .catch(error => console.error("Erro no fetch:", error));
      });
    });
  </script>
</body>
</html>
