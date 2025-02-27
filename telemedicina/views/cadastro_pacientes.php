<?php
session_start();
require_once "../config.php";
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Pacientes - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
      <header class="main-header">
        <h1>Cadastro de Pacientes</h1>
      </header>
      <section class="content">
        <div id="msgPaciente"></div>
        <form id="formPaciente" method="POST" class="mb-4">
          <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome do Paciente" required>
          </div>
          <div class="mb-3">
            <input type="text" name="cpf" class="form-control" placeholder="CPF do Paciente" required>
          </div>
          <div class="mb-3">
            <select name="plano" class="form-select" required>
              <option value="">Selecione o Plano</option>
              <option value="0">0</option>
              <option value="1">1</option>
            </select>
          </div>
          <div class="mb-3">
            <input type="date" name="data_nascimento" class="form-control" placeholder="Data de Nascimento">
          </div>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Cadastrar Paciente</button>
        </form>
        <hr>
        <h4>Lista de Pacientes</h4>
        <div id="listaPacientes">
          <?php include '../assets/ajax/lista_pacientes.php'; ?>
        </div>
      </section>
    </main>
  </div>
  <?php include 'footer.php'; ?>
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function(){
      const formPaciente = document.getElementById("formPaciente");
      formPaciente.addEventListener("submit", function(e){
        e.preventDefault();
        const formData = new FormData(formPaciente);
        fetch("../assets/ajax/cadastrar_paciente.php", {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          const msgDiv = document.getElementById("msgPaciente");
          if(data.success) {
            msgDiv.innerHTML = "<div class='alert alert-success'>Paciente cadastrado com sucesso!</div>";
            formPaciente.reset();
            fetch("../assets/ajax/lista_pacientes.php")
              .then(resp => resp.text())
              .then(html => { document.getElementById("listaPacientes").innerHTML = html; });
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
