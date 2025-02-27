<?php
session_start();
require_once "../config.php";

if (!isset($_GET["id"])) {
  header("Location: cadastro_medicos.php");
  exit;
}

$id = trim($_GET["id"]);
$stmt = $conn->prepare("SELECT * FROM tbmedicos WHERE medico = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$medico = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$medico) {
  echo "Médico não encontrado.";
  exit;
}

$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = trim($_POST["nome"] ?? "");
  $crm = trim($_POST["crm"] ?? "");
  $especialidade = trim($_POST["especialidade"] ?? "");
  if (!empty($nome) && !empty($crm)) {
    $stmtUpdate = $conn->prepare("UPDATE tbmedicos SET nome = :nome, CRM = :crm, especialidade_FK = :especialidade WHERE medico = :id");
    $stmtUpdate->bindParam(":nome", $nome);
    $stmtUpdate->bindParam(":crm", $crm);
    $stmtUpdate->bindParam(":especialidade", $especialidade);
    $stmtUpdate->bindParam(":id", $id);
    if ($stmtUpdate->execute()) {
      $mensagem = "Médico atualizado com sucesso!";
    } else {
      $mensagem = "Erro ao atualizar médico.";
    }
  } else {
    $mensagem = "Preencha os campos obrigatórios.";
  }
}

$stmtEsp = $conn->prepare("SELECT especialidade, descricao FROM tbespecialidades");
$stmtEsp->execute();
$especialidades = $stmtEsp->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Editar Médico - Salves Health</title>
  <link rel="stylesheet" href="../assets/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
</head>
<body>
  <div class="wrapper">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
      <header class="main-header">
        <h1>Editar Médico</h1>
      </header>
      <section class="content">
        <?php if (!empty($mensagem)) echo "<div class='alert alert-info'>$mensagem</div>"; ?>
        <form method="POST" class="mb-4">
          <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome do Médico" value="<?php echo htmlspecialchars($medico['nome']); ?>" required>
          </div>
          <div class="mb-3">
            <input type="text" name="crm" class="form-control" placeholder="CRM do Médico" value="<?php echo htmlspecialchars($medico['CRM']); ?>" required>
          </div>
          <div class="mb-3">
            <select name="especialidade" class="form-select" required>
              <option value="">Selecione a Especialidade</option>
              <?php foreach($especialidades as $esp): ?>
                <option value="<?php echo $esp['especialidade']; ?>" <?php if($medico['especialidade_FK'] == $esp['especialidade']) echo "selected"; ?>>
                  <?php echo $esp['descricao']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Atualizar Médico</button>
          <a href="cadastro_medicos.php" class="btn btn-secondary ms-2"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
        </form>
      </section>
    </main>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
