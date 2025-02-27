<?php
session_start();
require_once "../config.php";

$selectedPaciente = "";
if (isset($_GET["paciente"])) {
  $selectedPaciente = trim($_GET["paciente"]);
}

$stmtPacientes = $conn->prepare("SELECT paciente, nome FROM tbpacientes");
$stmtPacientes->execute();
$pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);

$consultas = [];
if (!empty($selectedPaciente)) {
  $stmtConsultas = $conn->prepare("SELECT c.consulta, c.data, c.horario, m.nome as medico_nome
                                  FROM tbconsultas c
                                  LEFT JOIN tbmedicos m ON c.medico_FK = m.medico
                                  WHERE c.paciente_FK = :paciente");
  $stmtConsultas->bindParam(":paciente", $selectedPaciente);
  $stmtConsultas->execute();
  $consultas = $stmtConsultas->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Histórico Paciente-Médico - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
      <header class="main-header">
        <h1>Histórico Paciente-Médico</h1>
      </header>
      <section class="content">
        <form method="GET" class="mb-4">
          <div class="mb-3">
            <select name="paciente" class="form-select" onchange="this.form.submit()" required>
              <option value="">Selecione um Paciente</option>
              <?php foreach($pacientes as $paciente): ?>
              <option value="<?php echo $paciente["paciente"]; ?>" <?php if($selectedPaciente == $paciente["paciente"]) echo "selected"; ?>>
                <?php echo $paciente["nome"]; ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
        </form>
        <?php if (!empty($selectedPaciente)): ?>
        <h4>Consultas Realizadas</h4>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Médico</th>
              <th>Data</th>
              <th>Horário</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($consultas)): ?>
              <?php foreach($consultas as $consulta): ?>
              <tr>
                <td><?php echo $consulta["consulta"]; ?></td>
                <td><?php echo $consulta["medico_nome"]; ?></td>
                <td><?php echo $consulta["data"]; ?></td>
                <td><?php echo $consulta["horario"]; ?></td>
                <td>
                  <a href="excluir_consulta.php?id=<?php echo $consulta["consulta"]; ?>" class="btn-icon" onclick="return confirm('Deseja realmente excluir esta consulta?');"><i class="fa-solid fa-trash"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5">Nenhuma consulta encontrada para este paciente.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        <?php endif; ?>
      </section>
    </main>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
