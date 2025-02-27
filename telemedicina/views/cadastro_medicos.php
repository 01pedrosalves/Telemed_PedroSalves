<?php
session_start();

require_once "../config.php";

$mensagem = ""; 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Médicos - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
      <header class="main-header">
        <h1>Cadastro de Médicos</h1>
      </header>
      <section class="content">
        <div id="msgMedico"></div>
        <form id="formMedico" method="POST" class="mb-4">
          <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome do Médico" required>
          </div>
          <div class="mb-3">
            <input type="text" name="crm" class="form-control" placeholder="CRM do Médico" required>
          </div>
          <div class="mb-3">
            <select name="especialidade" class="form-select" required>
              <option value="">Selecione a Especialidade</option>
              <?php 
                $stmtEsp = $conn->prepare("SELECT especialidade, descricao FROM tbespecialidades");
                $stmtEsp->execute();
                $especialidades = $stmtEsp->fetchAll(PDO::FETCH_ASSOC);
                foreach($especialidades as $esp): 
              ?>
              <option value="<?php echo $esp['especialidade']; ?>"><?php echo $esp['descricao']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Cadastrar Médico</button>
        </form>
        <hr>
        <h4>Lista de Médicos</h4>
        <div id="listaMedicos">
          <?php 
            include '../assets/ajax/lista_medicos.php';
          ?>
        </div>
      </section>
    </main>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
document.addEventListener("DOMContentLoaded", function(){
  const formMedico = document.getElementById("formMedico");
  formMedico.addEventListener("submit", function(e){
    e.preventDefault();
    const formData = new FormData(formMedico);
    fetch("../assets/ajax/cadastrar_medico.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      const msgDiv = document.getElementById("msgMedico");
      if(data.success) {
        msgDiv.innerHTML = "<div class='alert alert-success'>Médico cadastrado com sucesso!</div>";
        formMedico.reset();
        fetch("../assets/ajax/lista_medicos.php")
          .then(resp => resp.text())
          .then(html => { document.getElementById("listaMedicos").innerHTML = html; });
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
