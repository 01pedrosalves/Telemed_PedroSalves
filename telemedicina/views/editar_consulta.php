<?php
session_start();
require_once "../config.php";

if (!isset($_GET["id"])) { 
  header("Location: cadastro_consultas.php"); 
  exit; 
}
$id = trim($_GET["id"]);
$stmt = $conn->prepare("SELECT * FROM tbconsultas WHERE consulta = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$consulta) {
  echo "Consulta não encontrada.";
  exit;
}

$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $medico = trim($_POST["medico"] ?? "");
  $paciente = trim($_POST["paciente"] ?? "");
  $data = trim($_POST["data"] ?? "");
  $horario = trim($_POST["horario"] ?? "");
  
  if (!empty($medico) && !empty($paciente) && !empty($data) && !empty($horario)) {
    $stmtUpdate = $conn->prepare("UPDATE tbconsultas SET medico_FK = :medico, paciente_FK = :paciente, data = :data, horario = :horario WHERE consulta = :id");
    $stmtUpdate->bindParam(":medico", $medico);
    $stmtUpdate->bindParam(":paciente", $paciente);
    $stmtUpdate->bindParam(":data", $data);
    $stmtUpdate->bindParam(":horario", $horario);
    $stmtUpdate->bindParam(":id", $id);
    if ($stmtUpdate->execute()) {
      $mensagem = "Consulta atualizada com sucesso!";
    } else {
      $mensagem = "Erro ao atualizar consulta.";
    }
  } else {
    $mensagem = "Preencha todos os campos obrigatórios.";
  }
}

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
  <title>Editar Consulta - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
      <header class="main-header">
        <h1>Editar Consulta</h1>
      </header>
      <section class="content">
        <?php if (!empty($mensagem)) echo "<div class='alert alert-info'>$mensagem</div>"; ?>
        <form method="POST" class="mb-4">
          <div class="mb-3">
            <select name="medico" class="form-select" required>
              <option value="">Selecione um Médico</option>
              <?php foreach($medicos as $medico): ?>
              <option value="<?php echo $medico["medico"]; ?>" <?php if($consulta["medico_FK"] == $medico["medico"]) echo "selected"; ?>>
                <?php echo $medico["nome"]; ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <select name="paciente" class="form-select" required>
              <option value="">Selecione um Paciente</option>
              <?php foreach($pacientes as $paciente): ?>
              <option value="<?php echo $paciente["paciente"]; ?>" <?php if($consulta["paciente_FK"] == $paciente["paciente"]) echo "selected"; ?>>
                <?php echo $paciente["nome"]; ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <input type="date" name="data" class="form-control" value="<?php echo $consulta["data"]; ?>" required>
          </div>
          <div class="mb-3">
            <input type="time" name="horario" class="form-control" value="<?php echo $consulta["horario"]; ?>" required>
          </div>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Atualizar Consulta</button>
          <a href="cadastro_consultas.php" class="btn btn-secondary ms-2"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        </form>
      </section>
    </main>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
